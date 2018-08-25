package project.innovation.com.project.Adapters;

import android.content.Context;
import android.support.v4.view.PagerAdapter;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.squareup.picasso.Picasso;

import project.innovation.com.project.R;

/**
 * Created by PC on 11/21/2016.
 */
public class SliderViewPagerAdapter extends PagerAdapter {

    private Context mContext;
    private String[] mResources;

    public SliderViewPagerAdapter(Context mContext, String[] mResources) {
        this.mContext = mContext;
        this.mResources = mResources;
    }

    @Override
    public int getCount() {
        return mResources.length;
    }

    @Override
    public boolean isViewFromObject(View view, Object object) {
        return view == ((LinearLayout) object);
    }

    @Override
    public Object instantiateItem(ViewGroup container, int position) {
        View itemView = LayoutInflater.from(mContext).inflate(R.layout.design_for_slider_image_pager_item, container, false);

        ImageView imageView = (ImageView) itemView.findViewById(R.id.img_pager_item);
        Picasso.with(mContext)
                .load(mResources[position])
                .error(R.drawable.logo2)
                .into(imageView);

        container.addView(itemView);

        return itemView;
    }

    @Override
    public void destroyItem(ViewGroup container, int position, Object object) {
        container.removeView((LinearLayout) object);
    }
}
