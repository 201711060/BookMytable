package project.innovation.com.project.Helper;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Environment;
import android.util.Log;

public class Download {

	public static int getBinary(String URL, String SaveDirectory, String SaveFileName)
	{
		try
		{
			URL u = new URL(URL);
			HttpURLConnection c = (HttpURLConnection) u.openConnection();
			c.setRequestMethod("GET");
			c.setDoOutput(true);
			c.connect();

			File sdCard = Environment.getExternalStorageDirectory();
			File directory = new File (sdCard.getAbsolutePath() + "/" + SaveDirectory);
			directory.mkdirs();
			File file = new File(directory, SaveFileName);
			FileOutputStream f = new FileOutputStream(file);

			InputStream in = c.getInputStream();

			byte[] buffer = new byte[1024];
			int len1 = 0;

			while ( (len1 = in.read(buffer)) > 0 ) {
				f.write(buffer,0, len1);
			}

			f.close();

			return 1;
		}
		catch(Exception e) { Log.v("mye","Download - getBinary: " + e.toString()); }

		return 0;
	}

	public static String getText(String URL)
	{
		int BUFFER_SIZE = 2000;
		InputStream in = null;
		
		try{
			in = OpenHttpConnection(URL);
		} catch(IOException e) {
			Log.d("GetText: ", e.getLocalizedMessage());
		}
		
		InputStreamReader isr = new InputStreamReader(in);
		
		int charRead;
		String str = "";
		char[] inputBuffer = new char[BUFFER_SIZE]; 
		
		try{
			while((charRead = isr.read(inputBuffer))>0) { 
				String readString = String.copyValueOf(inputBuffer, 0, charRead); 
				str += readString;
				inputBuffer = new char[BUFFER_SIZE];
			}
			in.close();
		} catch(IOException e) {
			Log.d("GetText: ", e.getLocalizedMessage());
			return "";
		} 
		return str;
	}
	
	public static Bitmap getImage(String URL)
	{ 
		Bitmap bitmap = null;
		InputStream in = null;
		
		try{
			
			in = OpenHttpConnection(URL);
			bitmap = BitmapFactory.decodeStream(in);
			in.close();
			
		} catch(IOException e1) {
			
			Log.d("DownloadImage: ", e1.getLocalizedMessage());
			
		}
		
		return bitmap; 
	}
	
	private static InputStream OpenHttpConnection(String urlString) throws IOException
	{
		InputStream in = null;
		int response = -1;
		URL url = new URL(urlString); 
		URLConnection conn = url.openConnection();
		
		if(!(conn instanceof HttpURLConnection)) 
			throw new IOException("Not an HTTP connection");
		
		try{
			
			HttpURLConnection httpConn = (HttpURLConnection) conn;
			httpConn.setAllowUserInteraction(false);
			httpConn.setInstanceFollowRedirects(true);
			httpConn.setRequestMethod("GET");
			httpConn.connect();
			response = httpConn.getResponseCode(); 
			
			if(response == HttpURLConnection.HTTP_OK) {
				in = httpConn.getInputStream(); 
			}
			
		}
		catch(Exception ex)
		{
			Log.d("OpenHttpConnection: ", ex.getLocalizedMessage());
			throw new IOException("Error Connecting");
		}
		return in; 
	}
	
	
}
