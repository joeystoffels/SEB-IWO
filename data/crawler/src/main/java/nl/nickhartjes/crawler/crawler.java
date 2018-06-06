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

//    Document doc = Jsoup.connect("http://en.wikipedia.org/").get();
    Document doc = Jsoup.parse(file, "UTF-8", "https://www.gamemania.nl/Games");
    log(doc.title());

    Elements articles = doc.select("article");
    for (Element article : articles) {
      log(article.toString());
    }
  }

  private static void log(String msg, String... vals) {
    System.out.println(String.format(msg, vals));
  }
}
