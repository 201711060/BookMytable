package project.innovation.com.project;

import android.app.ProgressDialog;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;
import project.innovation.com.project.Helper.GlobVars;

public class ordered_details extends AppCompatActivity {

    JSONObject jo_main, jo_data;
    JSONArray ja_booking_items;

    TextView tvName, tvDate, tvTime, tvPhn, tvTblNm, tvRstNm, tvRstAddr, tvRstEmail, tvYourItems, tvItemsQty;

    ListView lvDetails;

    ProgressDialog pd;

    GlobVars gv;

    String URL = "http://aisomex.net/trainee_projects/table_booking/api/get_booking_details.php";

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_ordered_details);
        setTitle("Your Booking Details");

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        prepare_variables();

        fill_data();
    }

    private void fill_data() {
        AsyncHttpClient client = new AsyncHttpClient();

        RequestParams params = new RequestParams();
        params.put("tbk_id", gv.booking_id);

        client.get(this, URL, params, new AsyncHttpResponseHandler() {

            @Override
            public void onStart() {
                show_progress();
            }

            @Override
            public void onFinish() {
                hide_progress();
            }

            @Override
            public void onSuccess(int statusCode, Header[] headers, byte[] responseBody) {
                try {
                    jo_main = new JSONObject(new String(responseBody));

                    if (jo_main.getString("status").equals("success")) {
                        jo_data = jo_main.getJSONObject("data");

                        set_data();

                        ja_booking_items = jo_data.getJSONArray("booking_items");

                        lvDetails.setAdapter(new DetailsAdapter());
                    } else {

                    }
                } catch (Exception e) {
                    Log.v("mye", "fill_data() :: ORDER DETAILS = " + e.toString());
                }
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, byte[] responseBody, Throwable error) {

            }
        });
    }

    private void set_data()
    {
        try {
            tvName.setText(jo_data.getString("tbk_nm"));
            tvDate.setText(jo_data.getString("tbk_date"));
            tvTime.setText(jo_data.getString("tbk_time_slot"));
            tvPhn.setText(jo_data.getString("tbk_phn"));
            tvRstNm.setText(jo_data.getString("rst_nm"));
            tvRstAddr.setText(jo_data.getString("rst_addr") + "\n" + jo_data.getString("rst_phn1"));
            tvRstEmail.setText(jo_data.getString("rst_email"));
            tvTblNm.setText("Your table no. is: "+jo_data.getString("tbl_nm"));
        }
        catch (Exception e)
        {
            Log.v("mye","set_data :: ORDERED DETAILS = " + e.toString());
        }
    }

    class DetailsAdapter extends BaseAdapter
    {
        @Override
        public int getCount() {
            return ja_booking_items.length();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            LayoutInflater lf = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);

            View v = lf.inflate(R.layout.design_layout_order_details_list, parent, false);

            TextView tvItem = (TextView) v.findViewById(R.id.tvOrderItem_design_details);
            TextView tvItemQty = (TextView) v.findViewById(R.id.tvOrderItemQty_design_details);

            try
            {
                String item = ja_booking_items.getJSONObject(position).getString("mitm_title");
                if(item.length() > 10)
                {
                    item = item.substring(0,10) + "...";
                }
                tvItem.setText(item);

                tvItemQty.setText(ja_booking_items.getJSONObject(position).getString("tbi_mitm_qty"));
            }
            catch (Exception e)
            {
                Log.v("mye","DetailsAdapter :: ORDERED DETAILS = " + e.toString());
            }

            return v;
         }
    }

    private void prepare_variables()
    {
        tvName = (TextView) findViewById(R.id.tvName_details);
        tvDate = (TextView) findViewById(R.id.tvDate_details);
        tvTime = (TextView) findViewById(R.id.tvTime_details);
        tvPhn = (TextView) findViewById(R.id.tvPhn_details);
        tvRstNm = (TextView) findViewById(R.id.tvRstNm_details);
        tvRstAddr = (TextView) findViewById(R.id.tvRstAddrPhn_details);
        tvRstEmail = (TextView) findViewById(R.id.tvRstEmail_details);
        tvTblNm = (TextView) findViewById(R.id.tvTblNm_details);

        tvYourItems = (TextView) findViewById(R.id.tvYourItems_disp);
        tvItemsQty = (TextView) findViewById(R.id.tvItemsQty_disp);

        lvDetails = (ListView) findViewById(R.id.lvDetails);

        gv = (GlobVars) getApplication();

        if(getIntent().getStringExtra("ordered").equals("yes"))
        {
            tvYourItems.setVisibility(View.VISIBLE);
            tvItemsQty.setVisibility(View.VISIBLE);
            lvDetails.setVisibility(View.VISIBLE);
        }
        else
        {
            tvYourItems.setVisibility(View.VISIBLE);
            tvYourItems.setText("You have ordered nothing !");
            tvItemsQty.setVisibility(View.GONE);
            lvDetails.setVisibility(View.GONE);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {

        MenuItem miDone = menu.add(0,1,1,"Done");
        miDone.setShowAsAction(MenuItem.SHOW_AS_ACTION_ALWAYS);
        miDone.setOnMenuItemClickListener(new MenuItem.OnMenuItemClickListener() {
            @Override
            public boolean onMenuItemClick(MenuItem item) {
                Intent i=new Intent(getApplicationContext(),ThankYouActivity.class);
                startActivity(i);


                return false;
            }
        });

        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId())
        {
            case android.R.id.home:
                onBackPressed();
                break;

            default:
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    private void show_progress() {
        pd = new ProgressDialog(this);
        pd.setMessage("Loading...");
        pd.setCancelable(false);
        pd.show();
    }

    private void hide_progress() {
        pd.dismiss();
    }
}

