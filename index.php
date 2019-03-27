<?php
/**
 * Created by PhpStorm.
 * User: coltguo
 * Date: 2019-03-27
 * Time: 09:21
 */

ini_set('date.timezone','Asia/Shanghai');
#error_reporting(E_ERROR);

require_once "./lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
require_once 'log.php';
require_once 'notify.php';

/**
 * 流程：
 * 1、调用统一下单，取得mweb_url，通过mweb_url调起微信支付中间页
 * 2、用户在微信支付收银台完成支付或取消支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */

$scene_info = '{"h5_info":{"type":"Wap","wap_url":"https://pay.qq.com","wap_name":"腾讯充值"}}';
$input = new WxPayUnifiedOrder();
$notify = new NativePay();
$input->SetBody("test");//商品描述
$input->SetAttach("test");//附加数据
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));//商户订单号
$input->SetTotal_fee("100");//总金额默认是分
$input->SetTime_start(date("YmdHis"));//交易开始时间
$input->SetTime_expire(date("YmdHis", time() + 600));//交易结束时间
$input->SetGoods_tag("test");//商品标记
$input->SetNotify_url("http://localhost:8011/example/notify.php");//微信回调地址
$input->SetTrade_type("MWEB");//交易类型
$input->SetScene_info($scene_info);//场景信息
$result = $notify->GetH5PayUrl($input);
var_dump($result['mweb_url']);
?>