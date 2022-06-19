const express = require("express");
const app = express();
const bodyParser = require("body-parser");
const puppeteer = require("puppeteer");
const port = process.env.PORT || 3000;

app.use(bodyParser.json()); // support json encoded bodies
app.use(bodyParser.urlencoded({ extended: true })); // support encoded bodies
app.get("/", (req, res) => {
    res.send("Puppetter )")
});
app.post("/scrape", bodyParser.text({type: '*/*'}), async (req, res) => {
    if(req.body){
        const data  = await  eval(req.body);
        return res.send(data);
    }else{
        res.send("Ops : script not found");
    }
});

app.listen(port, () =>
    console.log(`Example app listening on port ${port}!`)
);


const pdf = async (request  , response) => {
    let data = [];
    const browser = await puppeteer.launch({
        headless: true,
        args: ["--no-sandbox", "--disable-setuid-sandbox"]
    });

    const page = await browser.newPage();
    await page.setViewport({height : 1600 , width: 900 , deviceScaleFactor: 1})
    async function cleanup() {
        try {
            console.log("Cleaning up instances");
            await page.close();
            await browser.close();
        } catch (e) {
            console.log("Cannot cleanup instances");
        }
    }
    console.log(request.body);
    try {
        await page.goto("https://kv.ee" );
        const path = './pdf/' + (Math.random() + 1).toString(36).substring(7) +".pdf";
        await page.pdf({ path: path ,  format: 'a4' });
        response.contentType("text/html");
        return response.send(path);
        await cleanup();
    } catch (e) {
        console.log("Error happened", e);
        await page.screenshot({ path: "error.png" });
        await cleanup();
        return response.status(503).send({status: 1, message: "Oops !"});
    }
};

module.exports = pdf;

