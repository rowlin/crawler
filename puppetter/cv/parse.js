const puppeteer = require("puppeteer");

async function test1 (page) {
    await page.goto('https://www.cvkeskus.ee/toopakkumised?_track=index_click_job_search&op=search&search_location=landingpage&ga_track=homepage&dummy_locations=3&dummy_categories=8&search%5Bkeyword%5D=&mobile_search%5Bkeyword%5D=&tmp_city=&search%5Blocations%5D%5B%5D=3&tmp_cat=&search%5Bcategories%5D%5B%5D=8&tmp_city=&dummy_search%5Blocations%5D%5B%5D=3&tmp_category=&dummy_search%5Bcategories%5D%5B%5D=8&search%5Bkeyword%5D=&search%5Bexpires_days%5D=&search%5Bjob_lang%5D=ru&search%5Bsalary%5D=&search%5Bjob_salary%5D=3');
    await page.waitForSelector('#f_jobs_main');

    return  await page.$$eval('tr.f_job_row2', (links) => {
        var res = [];
        var i = 0;
        links.forEach((l, i) => {
                return res[i++] = {
                    'url': l.querySelector('td.main-column > a').href,
                    'text': l.querySelector('td.column.d-none.d-md-table-cell.main-column').innerText
                }
            }
        )
        return res;
    });
}

async function test2 (page) {

    await page.goto('https://cv.ee/ru/search?limit=20&offset=0&categories%5B0%5D=INFORMATION_TECHNOLOGY&towns%5B0%5D=312&keywords%5B0%5D=php&fuzzy=true&suitableForRefugees=false&isHourlySalary=false&isQuickApply=false&languages%5B0%5D=ru');
    await page.waitForSelector('.vacancies-list');

    return  await page.$$eval('.vacancies-list__item', (links ) => {
        var res = [];
        var i = 0;
        links.forEach( (l, i )=> {
                return res[i++] =  {
                    'url':  l.querySelector('a').href,
                    'text':  [].map.call(l.querySelectorAll('span') , function(obj){
                        return  obj.innerText;
                    })
                }
            }
        )
        return res;

    });
}


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


    const re1  = await test1(page);
    const page2 = await browser.newPage();
    const re2  =await test2(page2)

    return  re1.concat(re2)

    //return data;
    await browser.close();
})();
