package project.innovation.com.project;

import android.app.DatePickerDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

public class Booking_Details extends AppCompatActivity {
    EditText etDate;
    Spinner spTable;

    String URL, BOOKING_URL;

    JSONArray ja;
    JSONObject jo;

    ProgressDialog pd;

    Calendar calc;

    Context c;

    String table_id, selected_date;

    // IN BETWEEN COMMENTS CUSTOM DIALOG CONTROLS............................

    TextView tvTitle;
    Button btnSubmit, btnCancel;
    Spinner spTimeSlots;
    EditText etNm,etPhn,etNoP;

    String TIME_URL;

    JSONObject jo_time_url;
    JSONArray ja_time_url;

    List<String> time_list;
    // IN BETWEEN COMMENTS CUSTOM DIALOG CONTROLS............................

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_booking_details);
        setTitle("Booking Details");

        c = this;

        prepare_variables();
        show_progress();

        calc = Calendar.getInstance();
        final int mYear = calc.get(Calendar.YEAR);
        final int mMonth = calc.get(Calendar.MONTH);
        final int mDay = calc.get(Calendar.DAY_OF_MONTH);

        URL = "http://aisomex.net/trainee_projects/table_booking/api/get_table.php?rst_id=" + getIntent().getStringExtra("rstID");
        Log.v("mye", URL);
        new TablesDownloader().execute(URL);

        etDate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                DatePickerDialog dpd = new DatePickerDialog(c, new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker datePicker, int year, int month, int date) {
                        month++;
                        etDate.setText(year + "-" + month + "-" + date);

                        selected_date = etDate.getText().toString().trim();
                        //Toast.makeText(Booking_Details.this, year + " " + month + " " + date +"", Toast.LENGTH_SHORT).show();
                    }
                }, mYear, mMonth, mDay);

                dpd.show();
            }
        });

        spTable.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
                try {
                    table_id = ja.getJSONObject(spTable.getSelectedItemPosition()).getString("tblid");
                } catch (Exception e) {
                    Log.v("mye","spTable :: ON ITEM SELECTED :: booking details = " + e.toString());
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });
    }

    class TablesDownloader extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... params) {
            return Download.getText(params[0]);
        }

        @Override
        protected void onPostExecute(String s) {
            try {
                hide_progress();

                jo = new JSONObject(s);

                if (jo.getString("status").equals("success")) {
                    ja = jo.getJSONArray("data");
                    set_spinner_adapter();
                } else {
                    Toast.makeText(getApplicationContext(), jo.getString("message"), Toast.LENGTH_SHORT).show();
                }

            } catch (Exception e) {
                Log.v("mye", "MyDownloader - onPostExecute : " + e.toString());
            }
        }
    }

    private void set_spinner_adapter() {
        try {
            List<String> table_list = new ArrayList<String>();

            for (int i = 0; i < ja.length(); i++) {
                table_list.add(ja.getJSONObject(i).getString("tblnm"));
            }

            ArrayAdapter<String> ad = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, table_list);
            ad.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spTable.setAdapter(ad);

        } catch (Exception e) {
            Log.v("mye", "set_spinner_adapter : " + e.toString());
        }
    }

    public void btn_Confirm(View v) {

        show_dialog_for_time_slots();
    }

    private void show_dialog_for_time_slots()
    {
        LayoutInflater lf = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View dv = lf.inflate(R.layout.design_custom_alert_dialog_booking_slots, null, false);

        BOOKING_URL = "http://aisomex.net/trainee_projects/table_booking/api/add_booking.php?tbl_id="+table_id+"&date="+selected_date+"&slot=07:30%20PM&nm=harshil&phn=1234567890&members=5000";

        tvTitle = (TextView) dv.findViewById(R.id.tvTitle_booking_slots);
        btnSubmit = (Button) dv.findViewById(R.id.btnSubmitBooking);
        btnCancel = (Button) dv.findViewById(R.id.btnCancelBooking);

        etNm=(EditText)  dv.findViewById(R.id.etNm_booking_slots);
        etPhn=(EditText)  dv.findViewById(R.id.etPhn_booking_slots);
        etNoP=(EditText)  dv.findViewById(R.id.etNoP_booking_slots);

        spTimeSlots = (Spinner) dv.findViewById(R.id.spTimeSlots);

        time_list = new ArrayList<>();

        tvTitle.setText("Booking Slot");

        final Dialog ad = new Dialog(this);
        ad.requestWindowFeature(Window.FEATURE_NO_TITLE);
        ad.setContentView(dv);

        WindowManager.LayoutParams lp = new WindowManager.LayoutParams();
        lp.copyFrom(ad.getWindow().getAttributes());
        lp.width = WindowManager.LayoutParams.MATCH_PARENT;
        lp.height = WindowManager.LayoutParams.WRAP_CONTENT;
        ad.getWindow().setAttributes(lp);

        ad.show();

        btnSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(c, selected_date + " " + table_id, Toast.LENGTH_SHORT).show();
            }
        });

        btnCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                ad.dismiss();
            }
        });

        TIME_URL = "http://aisomex.net/trainee_projects/table_booking/api/get_empty_slots.php?tbl_id="+table_id+"&date="+selected_date;
        new TimeSlotsDownloader().execute(TIME_URL);
    }

    class TimeSlotsDownloader extends AsyncTask<String, Void, String>
    {
        @Override
        protected String doInBackground(String... s) {
            return Download.getText(s[0]);
        }

        @Override
        protected void onPostExecute(String s) {
            try
            {
                jo_time_url = new JSONObject(s);

                if(jo_time_url.getString("status").equals("success"))
                {
                    ja_time_url = jo_time_url.getJSONArray("data");

                    for(int i=0; i<ja_time_url.length(); i++)
                    {
                        time_list.add(ja_time_url.getString(i));
                    }

                    set_spinner_time_slots_adapter();
                }
                else
                {
                    Toast.makeText(c, jo_time_url.getString("message"), Toast.LENGTH_SHORT).show();
                }
            }
            catch (Exception e)
            {
                Log.v("mye","Timeslots downloader  = " + e.toString());
            }
        }
    }

    private void set_spinner_time_slots_adapter()
    {
        ArrayAdapter<String> ad = new ArrayAdapter<String>(c, android.R.layout.simple_spinner_item, time_list);
        ad.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spTimeSlots.setAdapter(ad);
    }

    private void prepare_variables() {
        etDate = (EditText) findViewById(R.id.etDate);
        spTable = (Spinner) findViewById(R.id.spTable);
    }

    private void show_progress() {
        pd = new ProgressDialog(this);
        pd.setCancelable(false);
        pd.setMessage("Wait...");
        pd.show();
    }

    private void hide_progress() {
        pd.dismiss();
    }
}
