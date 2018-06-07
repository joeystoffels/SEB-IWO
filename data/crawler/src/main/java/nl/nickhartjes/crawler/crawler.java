package nl.nickhartjes.crawler;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.File;
import java.io.IOException;

public class crawler {
  public static void main(String[] args) throws IOException {
    ClassLoader classloader = Thread.currentThread().getContextClassLoader();
    File file = new File(classloader.getResource("gamemania.html").getFile());

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

//    Document doc = Jsoup.connect("http://en.wikipedia.org/").get();
    Document doc = Jsoup.parse(file, "UTF-8", "https://www.gamemania.nl/Games");
    log(doc.title());

    Elements articles = doc.select("article");
    for (Element article : articles) {
//      log(article.toString());
      log("***********************");
      Element price = article.select(".price--new").first();
      log(price.attr("data-productpricenew"));

    }
  }

  private static void log(String msg, String... vals) {
    System.out.println(String.format(msg, vals));
  }
}
