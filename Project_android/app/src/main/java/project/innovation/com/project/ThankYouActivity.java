package project.innovation.com.project;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;

public class ThankYouActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_thank_you_activity);

        new Thread(new Runnable() {
            @Override
            public void run() {

                try
                {
                    Thread.sleep(3000);
                }
                catch (Exception e)
                {
                    Log.v("mye","Thread.Sleep() :: THANK YOU ACTIVITY = " + e.toString());
                }

                startActivity(new Intent(getApplicationContext(), MainActivity.class));
            }
        }).start();
    }
}
