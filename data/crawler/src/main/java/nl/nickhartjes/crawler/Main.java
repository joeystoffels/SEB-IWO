package nl.nickhartjes.crawler;

import java.io.IOException;


public class Main {

  public static void main(String[] args) throws IOException {
    Crawler crawler = new Crawler();
    crawler.crawl();
  }
}
