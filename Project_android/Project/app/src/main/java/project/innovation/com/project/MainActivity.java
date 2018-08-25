package project.innovation.com.project;


import android.app.ActionBar;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONObject;

public class MainActivity extends AppCompatActivity {
    String URL;
    ListView lvRes;
    ProgressDialog pd;

    JSONObject jo;
    JSONArray ja;


    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_list_activity);

        setTitle("Restaurants");

        lvRes = (ListView) findViewById(R.id.lvRes);
        lvRes.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                try {
                    String rstID = ja.getJSONObject(position).getString("rstID");

                    Intent i = new Intent(MainActivity.this, restaurants_details.class);
                    i.putExtra("rstID", rstID);
                    startActivity(i);

                } catch (Exception e) {
                    Log.v("mye", "onCreate: " + e.toString());
                }
            }
        });

        show_progress();
        URL = "http://aisomex.net/trainee_projects/table_booking/api/get_res.php";
        new MyDownloader().execute(URL);
    }

    class MyDownloader extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... params) {
            Log.v("mye","DO IN BG DOWNLOADER" + params[0]);
            return Download.getText(params[0]);
        }

        @Override
        protected void onPostExecute(String s) {
            try {
                hide_progress();

                jo = new JSONObject(s);

                if (jo.getString("status").equals("success")) {
                    ja = jo.getJSONArray("data");

                    lvRes.setAdapter(new MyAdapter());
                } else {
                    Toast.makeText(getApplicationContext(), "No data !", Toast.LENGTH_SHORT).show();
                }

            } catch (Exception e) {
                Log.v("mye", "MyDownloader - onPostExecute : " + e.toString());
            }

        }
    }

    class MyAdapter extends BaseAdapter {

        @Override
        public int getCount() {
            return ja.length();
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
            View v = lf.inflate(R.layout.layout_restaurants_list_activity_list_design, parent, false);

            TextView tvResNm = (TextView) v.findViewById(R.id.tvResNm_list_design);

            try {
                String resnm = ja.getJSONObject(position).getString("rstname");
                tvResNm.setText(resnm);

            } catch (Exception e) {
                Log.v("mye", "MyAdapter - getView : " + e.toString());
            }

            return v;
        }
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
