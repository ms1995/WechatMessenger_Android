package net.ngee.smsforward;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.provider.Telephony;
import android.telephony.SmsMessage;

public class SmsListener extends BroadcastReceiver {

    public static volatile String smsg = "";
    public static final String myNum = "YOUR_NUMBER_OR_IDENTIFIER";

    @Override
    public void onReceive(Context context, Intent intent) {
        String msg = "TO: " + myNum + "\n=================";

        if (intent.getAction().equals(Telephony.Sms.Intents.SMS_RECEIVED_ACTION)) {
            Bundle bundle = intent.getExtras();
            SmsMessage[] msgs = null;
            String msg_from;
            if (bundle != null) {
                try {
                    Object[] pdus = (Object[]) bundle.get("pdus");
                    msgs = new SmsMessage[pdus.length];
                    for (int i = 0; i < msgs.length; i++) {
                        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M)
                            msgs[i] = SmsMessage.createFromPdu((byte[]) pdus[i], "3gpp2");
                        else
                            msgs[i] = SmsMessage.createFromPdu((byte[]) pdus[i]);
                        msg_from = msgs[i].getOriginatingAddress();
                        String msgBody = msgs[i].getDisplayMessageBody();
                        msg += "\nFROM: " + msg_from + "\n" + msgBody + "\n=================";
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }

        smsg += msg + "\n\n";
        context.startService(new Intent().setClass(context, WechatSender.class));
    }

}
