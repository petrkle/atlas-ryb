package cz.kle.atlasryb;

import android.os.Bundle;
import org.apache.cordova.*;

public class AtlasRyb extends CordovaActivity 
{
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
				Bundle extras = getIntent().getExtras();
        if (extras != null && extras.getBoolean("cdvStartInBackground", false)) {
            moveTaskToBack(true);
        }
        loadUrl(launchUrl);
				appView.getView().setVerticalScrollBarEnabled(true);
    }
}
