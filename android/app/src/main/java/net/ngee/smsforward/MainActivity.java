package net.ngee.smsforward;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        SmsListener.smsg = "Started. (" + SmsListener.myNum + ")";
        startService(new Intent().setClass(this, WechatSender.class));
    }
}
