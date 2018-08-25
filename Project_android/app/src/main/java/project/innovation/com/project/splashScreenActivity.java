package project.innovation.com.project;

import android.content.Intent;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

public class splashScreenActivity extends AppCompatActivity {
    private static int splashTimeOut = 3000;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_splash);


        new Handler().postDelayed(new Runnable() {

            @Override
            public void run() {
                Intent intent = new Intent( splashScreenActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        }, splashTimeOut);
    }
}
