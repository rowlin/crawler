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
            const data = await eval(req.body);
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

