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
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.squareup.picasso.Picasso;

import org.json.JSONArray;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

public class food_categories extends AppCompatActivity {

    GridView gvFoodCat;

    ProgressDialog pd;

    JSONObject jo;
    JSONArray ja;

    String URL;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_food_categories);

        setTitle("Food Categories");

        prepare_variables();

        URL = "http://aisomex.net/trainee_projects/table_booking/api/get_cat_by_res.php";

        get_data();
    }

    private void get_data()
    {
        AsyncHttpClient client = new AsyncHttpClient();

        RequestParams params = new RequestParams();
        params.put("rst_id",getIntent().getStringExtra("rst_id"));

        client.get(URL, params, new AsyncHttpResponseHandler() {

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
                    jo = new JSONObject(new String(responseBody));

                    if(jo.getString("status").equals("success"))
                    {
                        ja = jo.getJSONArray("data");

                        gvFoodCat.setAdapter(new FoodCatAdapter());
                    }
                    else
                    {
                        Toast.makeText(food_categories.this, jo.getString("message"), Toast.LENGTH_SHORT).show();
                    }
                }
                catch (Exception e)
                {
                    Log.v("mye","onSuccess :: GET_DATA() :: FOOD_CATEGORIES = " + e.toString());
                }
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, byte[] responseBody, Throwable error) {}
        });
    }

    class FoodCatAdapter extends BaseAdapter
    {
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

            View v = lf.inflate(R.layout.layout_food_categories_list_design_grid, parent, false);

            ImageView ivImage_grid_design = (ImageView) v.findViewById (R.id.ivImage_grid_design);
            TextView tvTitle_grid_design = (TextView) v.findViewById (R.id.tvTitle_grid_design);

            try
            {
                tvTitle_grid_design.setText(ja.getJSONObject(position).getString("fcatnm"));
                Picasso.with(getApplicationContext())
                        .load(ja.getJSONObject(position).getString("fcatimg"))
                        .error(R.drawable.logo2)
                        .into(ivImage_grid_design);

            }
            catch (Exception e)
            {
                Log.v("mye","FoodCatAdapter :: FOOD CATEGORIES = " + e.toString());
            }

            return v;

        }
    }

    private void prepare_variables()
    {
        gvFoodCat = (GridView) findViewById(R.id.gvFoodCat);
        gvFoodCat.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id)
            {
                try
                {
                    Intent i = new Intent(getApplicationContext(), Menu_Items.class);
                    i.putExtra("fcatid", ja.getJSONObject(position).getString("fcatid"));
                    startActivity(i);
                }
                catch (Exception e)
                {
                    Log.v("mye","gvFoodCat :: ON ITEM CLICK :: FOOD CATEGORIES = " + e.toString());
                }

            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {

        MenuItem miCart = menu.add(0,1,1,"View Cart");
        miCart.setIcon(R.drawable.ic_view_cart);
        miCart.setShowAsAction(MenuItem.SHOW_AS_ACTION_ALWAYS);

        miCart.setOnMenuItemClickListener(new MenuItem.OnMenuItemClickListener() {
            @Override
            public boolean onMenuItemClick(MenuItem item) {

                Intent i = new Intent(getApplicationContext(), ordered_details.class);
                i.putExtra("ordered", "yes");
                startActivity(i);

                return false;
            }
        });

        return super.onCreateOptionsMenu(menu);
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
