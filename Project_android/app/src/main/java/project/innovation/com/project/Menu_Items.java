package project.innovation.com.project;

import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.squareup.picasso.Picasso;

import org.json.JSONArray;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;
import project.innovation.com.project.Helper.GlobVars;

public class Menu_Items extends AppCompatActivity {

    ListView lvItems;

    ProgressDialog pd;

    JSONObject jo;
    JSONArray ja;

    String URL;

    int qty;

    GlobVars gv;

    // PRE ORDER DIALOG CONTROLS IN BETWEEN COMMENTS
    Dialog ad;

    String menu_item_id;

    EditText etQty;
    ImageView ivPic1,ivPic2;
    Button btnPlus, btnMinus, btnOrder, btnCancel;
    // PRE ORDER DIALOG CONTROLS IN BETWEEN COMMENTS

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_menu_items);

        setTitle("Menu_Items");

        gv = (GlobVars) getApplication();

        prepare_variables();

        URL = "http://aisomex.net/trainee_projects/table_booking/api/get_item_by_fcat.php";

        lvItems.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id)
            {
                try
                {
                    menu_item_id = ja.getJSONObject(position).getString("mitmid");
                }
                catch (Exception e)
                {
                    Log.v("mye","lvItems :: onCLick :: MENU ITEMS ACTIVITY = " + e.toString());
                }

                pre_order_dialog(position);
            }
        });

        get_data();
    }

    private void pre_order_dialog(int pos)
    {
        LayoutInflater lf = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View dv = lf.inflate(R.layout.design_custom_alert_dialog_pre_order, null, false);

        ad = new Dialog(this);
        ad.requestWindowFeature(Window.FEATURE_NO_TITLE);
        ad.setContentView(dv);

        WindowManager.LayoutParams lp = new WindowManager.LayoutParams();
        lp.copyFrom(ad.getWindow().getAttributes());
        lp.width = WindowManager.LayoutParams.MATCH_PARENT;
        lp.height = WindowManager.LayoutParams.WRAP_CONTENT;
        ad.getWindow().setAttributes(lp);

        etQty = (EditText) dv.findViewById(R.id.etQty_dialog_pre_order);
        ivPic1 = (ImageView) dv.findViewById(R.id.ivPic1_dialog_pre_order);
        ivPic2 = (ImageView) dv.findViewById(R.id.ivPic2_dialog_pre_order);
        btnCancel = (Button) dv.findViewById(R.id.btnCancel_dialog_pre_order);
        btnOrder = (Button) dv.findViewById(R.id.btnOrder_dialog_pre_order);
        btnPlus = (Button) dv.findViewById(R.id.btnPlus_dialog_pre_order);
        btnMinus = (Button) dv.findViewById(R.id.btnMinus_dialog_pre_order);

        try {
            Picasso.with(this)
                    .load(ja.getJSONObject(pos).getString("mitmimg1"))
                    .error(R.drawable.logo2)
                    .into(ivPic1);

            Picasso.with(this)
                    .load(ja.getJSONObject(pos).getString("mitmimg2"))
                    .error(R.drawable.logo2)
                    .into(ivPic2);

        } catch (Exception e) {
            Log.v("mye","pre_order_dialog :: MENU ITEMS ACTIVITY = " + e.toString());
        }

        btnOrder.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v)
            {
                String qty = etQty.getText().toString().trim();
                String booking_id = gv.booking_id;
                add_order_item(qty, booking_id, menu_item_id);
            }
        });

        btnCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ad.dismiss();
            }
        });

        ad.show();

        btnPlus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if(etQty.getText().toString().trim().equals(""))
                {
                    return;
                }
                String no=etQty.getText().toString();

                qty=Integer.parseInt(no);
                qty++;
                etQty.setText(qty+"");
            }
        });


        btnMinus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if(etQty.getText().toString().trim().equals(""))
                {
                    return;
                }
                String no=etQty.getText().toString();
                /*if(etQty.getText().toString().equals("<=0") )
                {
                    etQty.setText("1");
                }*/
                qty=Integer.parseInt(no);
                qty--;
                if(qty<=0)
                    etQty.setText(1+"");
                else
                    etQty.setText(qty+"");
            }
        });
    }

    private void add_order_item(String qty, String booking_id, String menu_id)
    {
        String bookking_item_url = "http://aisomex.net/trainee_projects/table_booking/api/add_booking_item.php";

        AsyncHttpClient client = new AsyncHttpClient();

        RequestParams params = new RequestParams();
        params.put("tbk_id", booking_id);
        params.put("mitm_id", menu_id);
        params.put("mitm_qty", qty);

        client.get(bookking_item_url, params, new AsyncHttpResponseHandler() {

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
                    JSONObject jo = new JSONObject(new String(responseBody));

                    if(jo.getString("status").equals("success")) {
                        ad.dismiss();
                        Toast.makeText(Menu_Items.this, "Item added !", Toast.LENGTH_SHORT).show();
                    }
                }
                catch (Exception e)
                {
                    Log.v("","add_order_item :: onSuccess :: MENU ITEMS ACTIVITY " + e.toString());
                }
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, byte[] responseBody, Throwable error) {

            }
        });
    }

    private void get_data() {
        AsyncHttpClient client = new AsyncHttpClient();

        RequestParams params = new RequestParams();
        params.put("cat_id", getIntent().getStringExtra("fcatid"));

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

                    if (jo.getString("status").equals("success")) {
                        ja = jo.getJSONArray("data");

                        lvItems.setAdapter(new MenuItemsAdapter());
                    } else {
                        Toast.makeText(Menu_Items.this, jo.getString("message"), Toast.LENGTH_SHORT).show();
                    }
                } catch (Exception e) {
                    Log.v("mye", "get_data() :: MENU ITEM = " + e.toString());
                }
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, byte[] responseBody, Throwable error) {

            }
        });
    }

    class MenuItemsAdapter extends BaseAdapter {
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
            View v = lf.inflate(R.layout.layout_menu_items_list_design, parent, false);

            TextView tvMenu = (TextView) v.findViewById(R.id.tvMenu_Items_list_design);
            ImageView ivMenu = (ImageView) v.findViewById(R.id.ivMenu_Items_image);

            try {
                tvMenu.setText(ja.getJSONObject(position).getString("mitmtitle")+"\nRs : "+ja.getJSONObject(position).getString("mitmrate"));

                Picasso.with(getApplicationContext())
                        .load(ja.getJSONObject(position).getString("mitmimg1"))
                        .error(R.drawable.logo2)
                        .into(ivMenu);

            } catch (Exception e) {
                Log.v("mye", "MenuItemsAdapter :: Menu Items= " + e.toString());
            }

            return v;
        }
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

    private void prepare_variables() {
        lvItems = (ListView) findViewById(R.id.lvItems);
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
