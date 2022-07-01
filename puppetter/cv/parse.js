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

    await page.goto('https://cv.ee/ru/search?limit=20&offset=0&categories%5B0%5D=INFORMATION_TECHNOLOGY&towns%5B0%5D=312&keywords%5B0%5D=php&fuzzy=true&suitableForRefugees=false&isHourlySalary=false&isRemoteWork=false&isQuickApply=false&languages%5B0%5D=ru');
    await page.waitForSelector('.vacancies-list');

    let data = await page.$$eval('.vacancies-list__item', (links ) => {
        var res = [];
        var i = 0;
        links.forEach( (l, i )=> {
            return res[i++] =   {
                    'url':  l.querySelector('a').href,
                    'text':  [].map.call(l.querySelectorAll('span') , function(obj){
                        return obj.innerText;
                    }),
                }
            }
        )
        return res;
    });

    return data;
    //  await browser.close();
})();