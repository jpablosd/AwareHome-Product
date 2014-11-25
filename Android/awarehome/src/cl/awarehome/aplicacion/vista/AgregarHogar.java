package cl.awarehome.aplicacion.vista;

import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import cl.awarehome.aplicacion.R;
import cl.awarehome.aplicacion.conexion.DatosServidor;
import cl.awarehome.aplicacion.conexion.JSONParser;
import cl.awarehome.aplicacion.vista.Datos.DatosUsuario;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.Toast;

import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.GoogleMap.OnMarkerClickListener;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.splunk.mint.Mint;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class AgregarHogar extends FragmentActivity {
	
	String id_usuario_agregar_hogar, nombre_usuario;
	
	JSONParser jsonParser = new JSONParser();
	// JSON Node names
	private static final String TAG_SUCCESS = "TAG_SUCCESS";

	String URL_connect = DatosServidor.IpServidor() + DatosServidor.UrlAgregarHogar();

	private GoogleMap googleMap;
	double plong;
	double plat;
	
	String longitud_app, latitud_app;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.agregar_hogar);
		Mint.initAndStartSession(AgregarHogar.this, "d609afeb");
		
		Bundle extras = getIntent().getExtras();
		if (extras != null) {
			id_usuario_agregar_hogar  = extras.getString("id_usuario");//usuario
			Toast.makeText(getApplicationContext(), "id_usuario: "+id_usuario_agregar_hogar, Toast.LENGTH_LONG).show();	
			nombre_usuario = extras.getString("usuario");
			Toast.makeText(getApplicationContext(), "nombre usuario: "+nombre_usuario, Toast.LENGTH_LONG).show();	
		}else{
			id_usuario_agregar_hogar="error";
		}

		LocationManager lm = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
		LocationListener ll = new mylocationlistener();
		lm.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, ll);

		MapFragment mapFragment = (MapFragment) getFragmentManager().findFragmentById(R.id.map);
		googleMap = mapFragment.getMap();
		googleMap.setMyLocationEnabled(true);
		googleMap.setMapType(GoogleMap.MAP_TYPE_NORMAL);
		
	
		
		
	}//oncreate

	//----------- mylocationlistener -------------------
	class mylocationlistener implements LocationListener{
		@Override
		public void onLocationChanged(Location arg0) {
			if(arg0 != null){
				plong = arg0.getLongitude();
				plat = arg0.getLatitude();
			}
			else{
				Toast toast1 = Toast.makeText(getApplicationContext(),"Error: Encienda el gps", Toast.LENGTH_SHORT);
				toast1.show();   
			}
		}
		@Override
		public void onProviderDisabled(String arg0) {
		}
		@Override
		public void onProviderEnabled(String arg0) {
		}
		@Override
		public void onStatusChanged(String arg0, int arg1, Bundle arg2) {
		}

	}
	//----------- mylocationlistener -------------------


	@Override
	public boolean onCreateOptionsMenu(Menu menu) 
	{
		MenuInflater inflater = getMenuInflater();
		inflater.inflate(R.menu.menu_agregar_hogar, menu);
		return true;
	}
	@Override
	public boolean onOptionsItemSelected(MenuItem item) 
	{
		switch (item.getItemId()) 
		{
		case R.id.Opc1_agregar_hogar:
			//crear alerta
			Toast.makeText(getApplicationContext(), "Agregando hogar", Toast.LENGTH_LONG).show();

			Toast.makeText(getApplicationContext(), " Latitud: "+plat, Toast.LENGTH_LONG).show();
			Toast.makeText(getApplicationContext(), "Longitud: "+plong, Toast.LENGTH_LONG).show();

			googleMap.addMarker(new MarkerOptions().position(new LatLng(plat, plong))
					.title("Mi Hogar").snippet(nombre_usuario));
			
			latitud_app = Double.toString(plat);
			longitud_app = Double.toString(plong);
			
			//new AgregarHogarNuevo().execute();
			

			return true;
		case R.id.Opc2_agregar_hogar:
			 Intent a=new Intent(AgregarHogar.this, PersonalizarHogar.class);
             
             a.putExtra("id_usuario",id_usuario_agregar_hogar);
             a.putExtra("usuario", nombre_usuario);
             a.putExtra("latitud",latitud_app);
             a.putExtra("longitud",longitud_app);
             startActivity(a);
			
			finish();
			
		default:
			return super.onOptionsItemSelected(item);
		}
	}
	//--------- menu ----------------------------

	

	
	
	/** 
     * Distance in kilometers between two geo points. 
     * 
     * Example: 
     * 
     * double lat1 = -34.87001758635342; 
     * double lon1 = -56.16755962371826; 
     * double lat2 = -34.88487484011935; 
     * double lon2 = -56.1661434173584; 
     * 
     * double distance = distFrom(lat1, lon1, lat2, lon2); 
     * 
     * @param lat1 
     * @param lng1 
     * @param lat2 
     * @param lng2 
     * @return 
     */  
	/*
    double lat1 = -34.87001758635342; 
    double lon1 = -56.16755962371826; 
    double lat2 = -34.88487484011935; 
    double lon2 = -56.1661434173584; 
    
    double distance = distFrom(lat1, lon1, lat2, lon2);
    
    public static double distFrom(double lat1, double lng1, double lat2, double lng2) {  
        //double earthRadius = 3958.75;//miles  
        double earthRadius = 6371;//kilometers  
        double dLat = Math.toRadians(lat2 - lat1);  
        double dLng = Math.toRadians(lng2 - lng1);  
        double sindLat = Math.sin(dLat / 2);  
        double sindLng = Math.sin(dLng / 2);  
        double a = Math.pow(sindLat, 2) + Math.pow(sindLng, 2)  
                * Math.cos(Math.toRadians(lat1)) * Math.cos(Math.toRadians(lat2));  
        double c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));  
        double dist = earthRadius * c;  
  
        return dist;  
    } 
*/
	

}//class
