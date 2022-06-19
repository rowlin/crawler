
const puppeteer = require("puppeteer");

(async () => {
    const browser = await puppeteer.launch(
        { headless: false , devtools: true}
    );
    const page = await browser.newPage();
    await page.setViewport({
        width: 1240,
        height: 800,
        deviceScaleFactor: 1,
    });
    await page.goto('https://kv.ee');
    await page.screenshot({ path: 'example.png' });

    await page.evaluate(() => {
        document.querySelector("#onetrust-accept-btn-handler").click();
    });

    await page.goto('https://kv.ee/?act=member.login');

  //  await browser.close();
})();
