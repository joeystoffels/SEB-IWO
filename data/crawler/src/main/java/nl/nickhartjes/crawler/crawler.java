package nl.nickhartjes.crawler;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.*;

import java.io.IOException;
import java.net.URL;
import java.util.ArrayList;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

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

public class crawler {

  public static void main(String[] args) throws IOException {
    ClassLoader classloader = Thread.currentThread().getContextClassLoader();
    File file = new File(classloader.getResource("gamemania.html").getFile());

    String baseUrl = "https://www.gamemania.nl";

    Document doc = Jsoup.parse(file, "UTF-8", baseUrl);
    log(doc.title());

    Elements articles = doc.select("article");
    Integer counter = 1;

    for (Element article : articles) {
      log("***********************");

      ArrayList<String> specList = new ArrayList<String>();

      // Get title
      String gameTitle = article.select("span").first().attr("title");
      specList.add(gameTitle);

      // Get price
      String price = article.getElementsByClass("price--new").first().attr("data-productpricenew");
      specList.add(price);

      // Get product detail specs
      String productSpecsHref = article.select("a").first().attr("href");
      String urlProductSpecs = baseUrl + productSpecsHref;

      Document tempDoc = Jsoup.connect(urlProductSpecs).get();
      Elements tdElements = tempDoc.getElementsByClass("productItem-specifications").select("td");

      for (Element element : tdElements) {
        if (tdElements.indexOf(element) % 2 == 1)
          specList.add(element.text());
      }

      // Get platform
      String platform = urlProductSpecs.split("/")[4];
      specList.add(platform);

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

      specList.add(localImgUrl);
      specList.add(localBgImgUrl);

      // Get textBlock product detail in html
      Elements textBlockElement = tempDoc.getElementsByClass("textblock");
      Element textBlock = textBlockElement.get(textBlockElement.size() - 2);

      String[] splitHtml = textBlock.html().split("\n");
      StringBuilder htmlString = new StringBuilder();

      for (String item : splitHtml) {
        htmlString = htmlString.append(item);
      }

      specList.add(htmlString.toString());

      // Write data to .csv
      log("Saving data for "+ specList.get(0));
      log("Product counter: " + counter);
      writeToCsv(specList);

      // Download images
      downloadImage(imgUrl, platform, false);
      downloadImage(bannerImgUrl, platform, true);

      // Product counter
      counter++;
    }

    log("Total products: " + counter.toString());
  }

  private static void writeToCsv(ArrayList<String> array) throws IOException {
    StringBuilder sb = new StringBuilder();

    if (!new File("gameslist.csv").exists()) {
      sb.append("Titel");
      sb.append("|");
      sb.append("Prijs");
      sb.append("|");
      sb.append("Releasedatum");
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
      sb.append("htmlDetailsTekst");
      sb.append('\n');
    }

    FileWriter fileWriter = new FileWriter(new File("gameslist.csv"), true);

    for(String item : array) {
      sb.append(array.get(array.indexOf(item)));

      if (!(array.indexOf(item) == array.size() - 1)) {
        sb.append("|");
      } else {
        sb.append('\n');
      }
    }

    fileWriter.write(sb.toString());
    fileWriter.close();
    log("Data saved to CSV!");
  }

  private static void downloadImage(String strImageURL, String platform, boolean isBackgroundImg){

    String IMAGE_DESTINATION_FOLDER = "C:\\Users\\Joey\\Desktop\\HAN\\seb-iwo\\images";
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
