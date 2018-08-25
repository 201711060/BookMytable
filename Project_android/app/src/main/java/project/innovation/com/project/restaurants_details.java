package project.innovation.com.project;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONObject;

import project.innovation.com.project.Adapters.SliderViewPagerAdapter;
import project.innovation.com.project.Helper.Download;

public class restaurants_details extends AppCompatActivity {
    String URL;

    ProgressDialog pd;

    TextView tvResNm, tvEmail, tvPhn1, tvPhn2, tvDesc, tvAddr;
    ImageView ivPic;
    Button btnBook;

    JSONObject jo_main, jo_data;

    // (v) FOR SLIDER (IN BETWEEN COMMENTS)..................................................................
    ViewPager pager_images;
    LinearLayout pager_indicator;
    int dotsCount;
    ImageView[] dots;
    SliderViewPagerAdapter pagerAdapter;

    // (^) FOR SLIDER (IN BETWEEN COMMENTS)..................................................................

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_restaurant_details);
        setTitle("Restaurant Details");

        prepare_variables();
        show_progress();
        URL = "http://aisomex.net/trainee_projects/table_booking/api/get_res_by_id.php?rst_id=" + getIntent().getStringExtra("rstID");
        new RestaurantsDetailsDonwloader().execute(URL);

    }


    class RestaurantsDetailsDonwloader extends AsyncTask<String, Void, String>
    {
        @Override
        protected String doInBackground(String... strings) {
            return Download.getText(strings[0]);
        }

        @Override
        protected void onPostExecute(String s) {
            hide_progress();

            try
            {
                jo_main = new JSONObject(s);

                if(jo_main.getString("status").equals("success"))
                {
                    jo_data = jo_main.getJSONObject("data");

                    set_data();

                    String[] slider_imgs = {jo_data.getString("rstimg1"),jo_data.getString("rstimg2"),jo_data.getString("rstimg3")};

                    // (V) FOR SLIDER (IN BETWEEN COMMENTS)..................................................................
                    set_up_slider_images(slider_imgs);
                    // (^) FOR SLIDER (IN BETWEEN COMMENTS)..................................................................
                }
                else
                {
                    Toast.makeText(getApplicationContext(), jo_main.getString("message"), Toast.LENGTH_SHORT).show();
                }
            }
            catch (Exception e)
            {
                Log.v("mye","RestaurantsDetailsDonwloader :: RESTAURANT DETAILS ACTIVITY = " + e.toString());
            }
        }
    }

    private void set_up_slider_images(String[] slider_imgs)
    {
        pager_images = (ViewPager) findViewById(R.id.viewPager_rest_details);

        pager_indicator = (LinearLayout) findViewById(R.id.viewPagerCountDots_rest_details);

        pagerAdapter = new SliderViewPagerAdapter(restaurants_details.this, slider_imgs);
        pager_images.setAdapter(pagerAdapter);
        pager_images.setCurrentItem(0);
        pager_images.setOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {
                for (int i = 0; i < dotsCount; i++) {
                    dots[i].setImageDrawable(getResources().getDrawable(R.drawable.style_non_selected_item_dot));
                }

                dots[position].setImageDrawable(getResources().getDrawable(R.drawable.style_selected_item_dot));
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });
        setUiPageViewController();
    }
    // (V) FOR SLIDER (IN BETWEEN COMMENTS)..................................................................
    private void setUiPageViewController() {

        dotsCount = pagerAdapter.getCount();
        dots = new ImageView[dotsCount];

        for (int i = 0; i < dotsCount; i++) {
            dots[i] = new ImageView(this);
            dots[i].setImageDrawable(getResources().getDrawable(R.drawable.style_non_selected_item_dot));

            LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.WRAP_CONTENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT
            );

            params.setMargins(4, 0, 4, 0);

            pager_indicator.addView(dots[i], params);
        }

        dots[0].setImageDrawable(getResources().getDrawable(R.drawable.style_selected_item_dot));
    }

    // (^) FOR SLIDER (IN BETWEEN COMMENTS)..................................................................

    private void set_data()
    {
        try
        {
            tvResNm.setText(jo_data.getString("rstname"));
            tvDesc.setText(jo_data.getString("rstdesc"));
            tvAddr.setText(jo_data.getString("rstaddr"));
            tvEmail.setText(jo_data.getString("rstemail"));
            tvPhn1.setText(jo_data.getString("rstphn1"));
            tvPhn2.setText(jo_data.getString("rstphn2"));
        }catch (Exception e)
        {
            Log.v("mye","set_data() :: RESTAURANT DETAILS ACTIVITY = " + e.toString());
        }
    }

    public void btnBook_Click(View v) {
        try
        {
            String rstID = jo_data.getString("rstID");

            Intent i = new Intent(restaurants_details.this, Booking_Details.class);
            i.putExtra("rstID", rstID);
            startActivity(i);


        } catch (Exception e) {
            Log.v("mye", "onCreate: " + e.toString());
        }


    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {

        MenuItem miDone = menu.add(0,1,1,"Feedback");
        miDone.setShowAsAction(MenuItem.SHOW_AS_ACTION_ALWAYS);
        miDone.setOnMenuItemClickListener(new MenuItem.OnMenuItemClickListener() {
            @Override
            public boolean onMenuItemClick(MenuItem item) {
                Intent i=new Intent(getApplicationContext(),Feedback.class);
                i.putExtra("rst_nm",tvResNm.getText().toString());
                startActivity(i);

                return false;
            }
        });

        return super.onCreateOptionsMenu(menu);
    }

    private void prepare_variables() {
        tvResNm = (TextView) findViewById(R.id.tvResNm);
        tvEmail = (TextView) findViewById(R.id.tvEmail);
        tvAddr  = (TextView)findViewById(R.id.tvAddr);
        tvDesc = (TextView) findViewById(R.id.tvDesc);
        tvPhn1 = (TextView) findViewById(R.id.tvPhn1);
        tvPhn2 = (TextView) findViewById(R.id.tvPhn2);
       // ivPic = (ImageView) findViewById(R.id.ivPic);

        btnBook = (Button) findViewById(R.id.btnBook);
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
