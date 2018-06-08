package nl.nickhartjes.crawler;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.*;

import java.io.IOException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Date;

//<article>
// <a class="wrap" href="/games/psp/119002_crash-tag-team-racing--platinum?type=New">
//  <header>
//   <h1> <span data-webid="product-name" title="Crash Tag Team Racing - Platinum">Crash Tag Team Racing - Platinum</span> </h1>
//   <div class="meta">
//    <div class="spec  price price--used " data-webid="product-priceused" data-productpriceused="7.98">
//     <div class="value">
//      <span class="currency">€</span> 7
//      <span class="decimal">,98</span>
//      <span class="type">used</span>
//     </div>
//    </div>
//    <div class="spec  price price--new" data-webid="product-pricenew" data-productpricenew="19.98">
//     <div class="value">
//      <span class="currency">€</span> 19
//      <span class="decimal">,98</span>
//      <span class="type">new</span>
//     </div>
//    </div>
//   </div>
//  </header>
//  <figure>
//   <div class="image imageToFit" style="background: url(https://gamemania-sec.azureedge.net/-/media/Sites/GameMania/Products/Games/C/CRASH-BANDICOOT/Crash-Tag-Team-Racing/PSP/Crash-Tag-Team-Racing--Platinum/19002.jpg?v=1riUmagVIky7vV7KsvxC1Q&amp;Type=Medium)" title="Crash Tag Team Racing - Platinum"></div>
//  </figure> </a>
//</article>

public class Crawler {

  public void crawl() throws IOException {
    ClassLoader classloader = Thread.currentThread().getContextClassLoader();
    File file = new File(classloader.getResource("gamemania.html").getFile());

    String baseUrl = "https://www.gamemania.nl";

    Document doc = Jsoup.parse(file, "UTF-8", baseUrl);
    log(doc.title());

    Elements articles = doc.select("article");
    Integer counter = 1;

    for (Element article : articles) {

      Game game = new Game();

      log("***********************");
      log("Timestamp: " + new Date());

      // Get title
      String gameTitle = article.select("span").first().attr("title");
      game.titel = gameTitle;

      // Get price
      String price = article.getElementsByClass("price--new").first().attr("data-productpricenew");
      game.prijs = price;

      // Get product detail specs
      String productSpecsHref = article.select("a").first().attr("href");
      String urlProductSpecs = baseUrl + productSpecsHref;

      Document tempDoc = Jsoup.connect(urlProductSpecs).get();
      Elements tdElements = tempDoc.getElementsByClass("productItem-specifications").select("td");

      for (Element element : tdElements) {
        String elementTitle = element.wholeText();

        if (elementTitle.equals("Releasedatum"))
          game.releaseDatum = tdElements.get(tdElements.indexOf(element) + 1).text();
        if (elementTitle.equals("Aantal spelers"))
          game.aantalSpelers = tdElements.get(tdElements.indexOf(element) + 1).text();
        if (elementTitle.equals("Genre"))
          game.genre = tdElements.get(tdElements.indexOf(element) + 1).text();
        if (elementTitle.equals("PEGI leeftijd"))
          game.pegiLeeftijd = tdElements.get(tdElements.indexOf(element) + 1).text();
        if (elementTitle.equals("PEGI inhoud"))
          game.pegiInhoud = tdElements.get(tdElements.indexOf(element) + 1).text();
        if (elementTitle.equals("Publisher"))
          game.publisher = tdElements.get(tdElements.indexOf(element) + 1).text();
        if (elementTitle.equals("Ontwikkelaar"))
          game.ontwikkelaar = tdElements.get(tdElements.indexOf(element) + 1).text();
        if (elementTitle.equals("Gesproken taal"))
          game.gesprokenTaal = tdElements.get(tdElements.indexOf(element) + 1).text();
        if (elementTitle.equals("Geschreven taal"))
          game.geschrevenTaal = tdElements.get(tdElements.indexOf(element) + 1).text();
      }

      // Get platform
      String platform = urlProductSpecs.split("/")[4];
      game.platform = platform;

      // Get product specs background url
      Element bannerElement = tempDoc.getElementsByClass("banner").first();
      String bannerUrlTemp = bannerElement.attr("style");
      String bannerUrlTemp2 = bannerUrlTemp.split("[(]")[1];
      String bannerImgUrl = bannerUrlTemp2.split("[?]")[0];

      // Get product img URL
      Element imgHtml = article.select("div[style]").first();

      String urlTemp = imgHtml.attr("style");
      String urlTemp2 = urlTemp.split("[(]")[1];
      String imgUrl = urlTemp2.split("[?]")[0];

      // Get product name
      String[] array = imgUrl.split("/");
      String gameName = array[array.length - 2];

      // Add local img url's to list
      String localImgUrl = "" + platform + "/" + gameName + ".jpg";
      String localBgImgUrl = "" + platform + "/" + gameName + "_background" + ".jpg";

      game.localImgUrl = localImgUrl;
      game.localBgImgUrl = localBgImgUrl;

      // Get textBlock product detail in html
      Elements textBlockElement = tempDoc.getElementsByClass("textblock");
      Element textBlock = textBlockElement.get(textBlockElement.size() - 2);

      String[] splitHtml = textBlock.html().split("\n");
      StringBuilder htmlString = new StringBuilder();

      for (String item : splitHtml) {
        htmlString = htmlString.append(item);
      }

      game.htmlDetailTekst = htmlString.toString();

      // Write data to .csv
      log("Saving data for " + game);
      log("Product counter: " + counter);
      writeToCsv(game);

      // Download images
      try {
        downloadImage(imgUrl, platform, false);
        downloadImage(bannerImgUrl, platform, true);
      } catch (ArrayIndexOutOfBoundsException e) {
        log("Error while downloading an image... continue.");
      }

      // Product counter
      counter++;
    }

    log("" + new Date() + "Total products: " + counter.toString());
  }

  private static void writeToCsv(Game game) throws IOException {
    StringBuilder sb = new StringBuilder();

    if (!new File("gameslist.csv").exists()) {
      sb.append("Titel");
      sb.append("|");
      sb.append("Prijs");
      sb.append("|");
      sb.append("ReleaseDatum");
      sb.append("|");
      sb.append("AantalSpelers");
      sb.append("|");
      sb.append("Genre");
      sb.append("|");
      sb.append("PegiLeeftijd");
      sb.append("|");
      sb.append("PegiInhoud");
      sb.append("|");
      sb.append("Publisher");
      sb.append("|");
      sb.append("Ontwikkelaar");
      sb.append("|");
      sb.append("GesprokenTaal");
      sb.append("|");
      sb.append("GeschrevenTaal");
      sb.append("|");
      sb.append("Platform");
      sb.append("|");
      sb.append("LocalImgUrl");
      sb.append("|");
      sb.append("LocalBgImgUrl");
      sb.append("|");
      sb.append("HtmlDetailTekst");
      sb.append('\n');
    }

    FileWriter fileWriter = new FileWriter(new File("gameslist.csv"), true);

    sb = sb.append(game.titel).append("|").append(game.prijs).append("|").append(game.releaseDatum).append("|")
      .append(game.aantalSpelers).append("|").append(game.genre).append("|").append(game.pegiLeeftijd).append("|")
      .append(game.pegiInhoud).append("|").append(game.publisher).append("|").append(game.ontwikkelaar).append("|")
      .append(game.gesprokenTaal).append("|").append(game.geschrevenTaal).append("|").append(game.platform).append("|")
      .append(game.localImgUrl).append("|").append(game.localBgImgUrl).append("|").append(game.htmlDetailTekst).append("\n");

    fileWriter.write(sb.toString());
    fileWriter.close();
    log("Data saved to CSV!");
  }

  private static void downloadImage(String strImageURL, String platform, boolean isBackgroundImg){

    String IMAGE_DESTINATION_FOLDER = "C:/Users/Joey/Desktop/HAN/seb-iwo/images";
    String[] array = strImageURL.split("/");

    int productNameIndexPos = isBackgroundImg ? 3 : 2;
    String gameName = array[array.length - productNameIndexPos];

    File directory = new File(IMAGE_DESTINATION_FOLDER + "/" + platform);

    if (directory.mkdir()) {
      log("Img folder created: " + platform);
    }

    if (isBackgroundImg) {
      gameName += "_background" ;
    }

    String imgUrl = "/" + platform + "/" + gameName + ".jpg";
    log("Saving image to: " + IMAGE_DESTINATION_FOLDER + imgUrl);

      try {

        //open the stream from URL
        URL urlImage = new URL(strImageURL);
        InputStream in = urlImage.openStream();

        byte[] buffer = new byte[4096];
        int n = -1;

        OutputStream os =
          new FileOutputStream( IMAGE_DESTINATION_FOLDER + imgUrl);

        //write bytes to the output stream
        while ( (n = in.read(buffer)) != -1 ){
          os.write(buffer, 0, n);
        }

        //close the stream
        os.close();

        System.out.println("Image saved");

      } catch (IOException e) {
        e.printStackTrace();
      }
  }

  private static void log(String msg, String... vals) {
    System.out.println(String.format(msg, vals));
  }
}
