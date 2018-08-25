package project.innovation.com.project;

import android.content.Intent;
import android.net.Uri;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

public class Feedback extends AppCompatActivity {

    EditText etEmail, etMsg;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_feedback_form);
        setTitle("Feedback");

        prepare_vars();
    }

    public void btnSubmit_Click(View v)
    {
        if(etMsg.getText().toString().trim().equals(""))
        {
            Toast.makeText(Feedback.this, "Enter message !", Toast.LENGTH_SHORT).show();
            return;
        }
        if(etEmail.getText().toString().trim().equals(""))
        {
            Toast.makeText(Feedback.this, "Enter e-mail !", Toast.LENGTH_SHORT).show();
            return;
        }

        Intent intent = new Intent (Intent.ACTION_VIEW , Uri.parse("mailto:" + "bookmytablebmt@gmail.com"));
        intent.putExtra(Intent.EXTRA_SUBJECT, "Feedback / Suggestion");
        intent.putExtra(Intent.EXTRA_TEXT, getIntent().getStringExtra("rst_nm"));
        startActivity(intent);
    }

    private void prepare_vars()
    {
        etEmail = (EditText) findViewById(R.id.etEmail_feedback);
        etMsg = (EditText) findViewById(R.id.etMessage_feedback);
    }
}
