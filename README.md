# Wechat Messenger for Android

## What is it
A simple app that redirects all incoming SMS to specific Wechat accounts. It is useful when you have extra Android phones and don't bother to pick up them for verification codes or some other stuff.

## Requirements
* A web server running PHP >= 5.2
* Latest Android SDK
* AndroidStudio

## What you need to do
* Register a Wechat developer account.
* Register a new public account, or a new test public account.
* Subscribe to the new public account.
* Replace with your own credentials in `wx.php`.
* Replace with your server address in `WechatSender.java`.
* Make sure `wx.php` runs correctly on your server.
* Compile and run.

Wechat requires the subscribers to send messages to the public account in order to receive from it within 24 hours.

## License
WTFPL