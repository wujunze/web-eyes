'use strict';

var express = require("express");
var app = express();
var hostName = '127.0.0.1';
var port = 8080;
const wappalyzer = require('wappalyzer');
app.get('/', function (req, res) {
    var url = req.query.url;
    console.warn(url);
    wappalyzer.analyze(url, res)
        .then(function (json) {
            res.end(JSON.stringify(json));
        });
});
app.listen(port, hostName, function () {
    console.log("应用实例，访问地址为 http://%s:%s", hostName, port)
});