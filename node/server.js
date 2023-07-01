const express = require('express');
const axios = require('axios');
const app = express();
const cors = require('cors');
var bodyParser = require('body-parser');
var proxy   = require('express-http-proxy')
const { createProxyMiddleware } = require('http-proxy-middleware')

const HttpsProxyAgent = require('https-proxy-agent');

// app.use(bodyParser());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cors({
    origin: 'http://ylt.tdcmmcn.com'
  }));

var signs = require('./signature')

app.post('/user_profile',
    function (req, res) {
        let result = req.body;
        let kw = result.kw;
        result = signs.user_profile(kw);
        res.send(result)
    }
);

app.post('/comment',proxy(req => {
        return 'http://'+req.body.proxy_ip+":"+req.body.proxy_port
    },{
    proxyReqOptDecorator:function(proxyReq,originalReq){
        return proxyReq
    },
    userResDecorator: function(proxyRes, proxyResData, userReq, userRes) {
        let result = userReq.body;
        let kw = result.kw;
        let offset = result.offset;
        let count = result.count;
        result = signs.comment(kw,offset,count);
        return result
    },
}));
app.post('/search_item',proxy(req => {
        return 'http://'+req.body.proxy_ip+":"+req.body.proxy_port
    },{
    proxyReqOptDecorator:function(proxyReq,originalReq){
        return proxyReq
    },
    userResDecorator: function(proxyRes, proxyResData, userReq, userRes) {
        let result = userReq.body;
        let kw = result.kw;
        let count = result.count;
        let offset = result.offset;
        let sort_type = result.sort_type;
        let publish_time = result.publish_time;
        result = signs.search_item(kw,count,offset,sort_type,publish_time);
        return result
    },
}));

app.post('/aweme_post',proxy(req => {
        return 'http://'+req.body.proxy_ip+":"+req.body.proxy_port
    },{
    proxyReqOptDecorator:function(proxyReq,originalReq){
        return proxyReq
    },
    userResDecorator: function(proxyRes, proxyResData, userReq, userRes) {
        let result = userReq.body;
        let kw = result.kw;
        let count = result.count;
        let max_cursor = result.max_cursor;
        result = signs.aweme_post(kw,count,max_cursor);
        return result
    },
}));

app.post('/follow',proxy(req => {
        return 'http://'+req.body.proxy_ip+":"+req.body.proxy_port
    },{
    proxyReqOptDecorator:function(proxyReq,originalReq){
        return proxyReq
    },
    userResDecorator: function(proxyRes, proxyResData, userReq, userRes) {
        let result = userReq.body;
        let token = result.token;
        result = signs.follow(token);
        return result
    },
}));

app.get('/hello', (req, res) => {
    res.send('Hello World');
  });

app.use('/baidu', proxy('https://www.baidu.com'));

app.use('/appp', proxy('https://www.163.com'));


// 路由处理器，处理 /ppp 路径的 POST 请求
app.get('/youyou', (req, res, next) => {
    console.log('Request received:', req.query);
    next();
}, createProxyMiddleware({
    target: 'https://www.holdnetwork.cn',
    changeOrigin: true,
    headers: {
        Host: 'www.holdnetwork.cn',
    },
    onProxyReq(proxyReq, req, res) {
        const proxySettings = { host: '47.122.47.69', port: 6003 };
        console.log('Proxy settings:', proxySettings);
        proxyReq.setHeader('X-Forwarded-For', req.socket.remoteAddress);

        // 将代理设置添加到自定义响应头中
        res.setHeader('X-Proxy-Settings', JSON.stringify(proxySettings));
    },
    pathRewrite: {
        '^/youyou': '',
    },
    proxy: {
        host: '47.122.47.69',
        port: 6003
    },
    secure: false
}));

app.get('/youyou-proxy-settings', (req, res) => {
    const proxySettings = { host: '47.122.47.69', port: 6003 };
    res.json(proxySettings);
  });


app.listen(8003, () => {
    console.log('开服务，端口8003')
});
