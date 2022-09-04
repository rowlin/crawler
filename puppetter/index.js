const express = require("express");
const app = express();
const bodyParser = require("body-parser");
const puppeteer = require("puppeteer");
const port = process.env.PORT || 3000;
app.get("/", (req, res) => {
    res.send("Puppetter")
});
app.post("/scrape", bodyParser.text({type: '*/*'}), async (req, res) => {
    if(req.body){
        try {
            const data  =await eval(req.body);
            return res.status(200).send(data);
        }catch (e) {
            if(e.message){
                res.status(500).send(e.message );
            }else{
                res.status(501).send('Something was wrong');
            }
        }
    }else{
        res.status(503).send("Ops : script not found");
    }
});

app.post("/scrape_old", bodyParser.text({type: '*/*'}), async (req, res) => {
    if(req.body){
        try {
                await eval(req.body);

                const browser = await puppeteer.launch(
                    {
                        args: ['--no-sandbox', '--disable-setuid-sandbox'],
                        ignoreHTTPSErrors: true
                    }
                );
                const page = await browser.newPage();
                await page.setViewport({
                    width: 1240,
                    height: 800,
                    deviceScaleFactor: 1,
                });

                    const data = await run(page , browser);
                await browser.close();
            return res.status(200).send(data);
        }catch (e) {
            if(e.message){
                res.status(500).send(e.message );
            }else{
                res.status(501).send('Something was wrong');
            }
        }
    }else{
        res.status(503).send("Ops : script not found");
    }
});

app.listen(port, () =>
    console.log(`Example app listening on port ${port}!`)
);

