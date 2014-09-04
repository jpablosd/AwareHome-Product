package cl.awarehome.aplicacion.vista;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;
import java.util.Timer;
import java.util.TimerTask;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import cl.awarehome.aplicacion.R;
import cl.awarehome.aplicacion.conexion.*;
import de.passsy.holocircularprogressbar.HoloCircularProgressBar;
import android.animation.Animator;
import android.animation.ObjectAnimator;
import android.animation.ValueAnimator;
import android.animation.Animator.AnimatorListener;
import android.animation.ValueAnimator.AnimatorUpdateListener;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class Datos extends Activity{

	double temperatura, humedad;
	String buscar= "1";
	String usuario;
	
	//progress Dialog
	private ProgressDialog pDialog;
	//creating JSON parser object
	JSONParser jparser = new JSONParser();
	
	private static String url_all_empleados = DatosServidor.IpServidor() + DatosServidor.UrlDatos();
	
	//JSON node names
	private static final String TAG_SUCCESS = "success";
	private static final String TAG_empleados = "datos";
	private static final String TAG_NOMBRE = "temperatura";
	private static final String TAG_CEDULA = "humedad";
	
	JSONArray empleados = null;

	private static final String TAG = Datos.class.getSimpleName();

	private Button mColorSwitchButton;

	private HoloCircularProgressBar mHoloCircularProgressBar;
	private ObjectAnimator mProgressBarAnimator;
	protected boolean mAnimationHasEnded = false;

	private TextView temp;
	private TextView hum;
	private TextView user;

	@Override
	protected void onCreate(final Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.datos);
		
		user = (TextView) findViewById(R.id.usuario);
		
		Bundle extras = getIntent().getExtras();
        if (extras != null) {
     	   usuario  = extras.getString("usuario");//usuario
     	   user.setText(usuario);
        }else{
     	   usuario="error";
     	}

		mHoloCircularProgressBar = (HoloCircularProgressBar) findViewById(R.id.holoCircularProgressBar1);
		
		temp = (TextView) findViewById(R.id.temperatura);
		hum = (TextView) findViewById(R.id.humedad);
		
        //Creamos el Timer
      		Timer timer = new Timer();
      		//Que actue cada 3000 milisegundos
      		//Empezando des de el segundo 0
      		timer.scheduleAtFixedRate(new TimerTask() {
      			@Override
      			public void run() {
      				//La función que queremos ejecutar
      				FuncionParaEsteHilo();
      			}
      		}, 0, 5000);
		
      		switchColor();
			Animar();
	}//onCreate
	
	private void FuncionParaEsteHilo()
	{
	    //Esta función es llamada des de dentro del Timer
		//Para no provocar errores ejecutamos el Accion
		//Dentro del mismo Hilo
	    this.runOnUiThread(Accion);
	}

	private Runnable Accion = new Runnable() {
	    public void run() {
	    //Aquí iría lo que queramos que haga,
	    //en este caso mostrar un mensaje.
	    	//Toast.makeText(getApplicationContext(), "Tiempo!", Toast.LENGTH_LONG).show();
	    	new CargaDeDatos().execute();
	    	switchColor();
	    }
	};
	
	//Definimos que para cuando se presione la tecla BACK no volvamos para atras  	 
	 @Override
	 public boolean onKeyDown(int keyCode, KeyEvent event)  {
	     if (keyCode == KeyEvent.KEYCODE_BACK && event.getRepeatCount() == 0) {
	         // no hacemos nada.
	         return true;
	     }
	     return super.onKeyDown(keyCode, event);
	 }
	 
	//___________________________________________
	protected void Animar(){
		animate(mHoloCircularProgressBar, new AnimatorListener() {
			@Override
			public void onAnimationCancel(final Animator animation) {
				animation.end();
			}
			@Override
			public void onAnimationEnd(final Animator animation) {
				if (!mAnimationHasEnded) {
					animate(mHoloCircularProgressBar, this);
				} else {
					mAnimationHasEnded = false;
				}
			}
			@Override
			public void onAnimationRepeat(final Animator animation) {
			}
			@Override
			public void onAnimationStart(final Animator animation) {
			}
		});
	}
	
	/**
	 * generates random colors for the ProgressBar
	 */
	protected void switchColor() {
		Random r = new Random();
		int randomColor = Color.rgb(r.nextInt(256), r.nextInt(256), r.nextInt(256));
		mHoloCircularProgressBar.setProgressColor(randomColor);

		randomColor = Color.rgb(r.nextInt(256), r.nextInt(256), r.nextInt(256));
		mHoloCircularProgressBar.setProgressBackgroundColor(randomColor);
	}

	private void animate(final HoloCircularProgressBar progressBar, final AnimatorListener listener) {
		final float progress = (float) (Math.random() * 2);
		int duration = 30000;
		animate(progressBar, listener, progress, duration);
	}

	private void animate(final HoloCircularProgressBar progressBar, final AnimatorListener listener,
			final float progress, final int duration) {

		mProgressBarAnimator = ObjectAnimator.ofFloat(progressBar, "progress", progress);
		mProgressBarAnimator.setDuration(duration);
		mProgressBarAnimator.addListener(new AnimatorListener() {
			@Override
			public void onAnimationCancel(final Animator animation) {
			}
			@Override
			public void onAnimationEnd(final Animator animation) {
				progressBar.setProgress(progress);
			}
			@Override
			public void onAnimationRepeat(final Animator animation) {
			}
			@Override
			public void onAnimationStart(final Animator animation) {
			}
		});
		if (listener != null) {
			mProgressBarAnimator.addListener(listener);
		}
		mProgressBarAnimator.reverse();
		mProgressBarAnimator.addUpdateListener(new AnimatorUpdateListener() {

			@Override
			public void onAnimationUpdate(final ValueAnimator animation) {
				progressBar.setProgress((Float) animation.getAnimatedValue());
			}
		});
		progressBar.setMarkerProgress(progress);
		mProgressBarAnimator.start();
	}

	 //--------------------------------------------------------
	 class CargaDeDatos extends AsyncTask<String, String, String>{
		@Override
		protected void onPreExecute(){
			super.onPreExecute();
			/*
			pDialog = new ProgressDialog(CircularProgressBarSample.this);
			pDialog.setMessage("cargando direccion");
			pDialog.setIndeterminate(false);
			pDialog.setCancelable(false);
			pDialog.show();
			*/
		}
		@Override
		protected String doInBackground(String... params) {
			//building parameters	
			List<NameValuePair> params1 = new ArrayList<NameValuePair>();
			params1.add(new BasicNameValuePair("buscar", buscar));
			//getting JSON string from URL
			JSONObject json = jparser.makeHttpRequest(url_all_empleados,"POST", params1);
			//checj your log cat for JSON response
			Log.d("todas los datos: ", json.toString());
			
			try{
				//checking for success tag
				int success = json.getInt(TAG_SUCCESS);
				if(success == 1){
					//empleados found
					empleados = json.getJSONArray(TAG_empleados);
					//looping through all empleados
					for(int i=0; i<empleados.length();i++){
						JSONObject c = empleados.getJSONObject(i);
						//storig each json item in variable
						temperatura = c.getDouble(TAG_NOMBRE);
						humedad = c.getDouble(TAG_CEDULA);

					}
				}else{
					//no empleados found
					Intent i = new Intent(getApplicationContext(),Datos.class);
					//closing all previus activities
					i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
					startActivity(i);
				}
			}catch(JSONException e){
				e.printStackTrace();
			}
			return null;
		}//doInBackground
		
		protected void onPostExecute(String file_url){
			//dismiss the dialog after getting all empleados
			
			//pDialog.dismiss();
           //Toast.makeText(getApplicationContext(), "temperatura: "+temperatura+ "humedad: "+humedad, Toast.LENGTH_LONG).show();
           String t = String.valueOf(temperatura);
           temp.setText(t+"ºC");
           String h = String.valueOf(humedad);
           hum.setText(h+"%");
           //float lat = Float.parseFloat(lati);	
		}
	 }//CargaDeDatos
	 //--------------------------------------------------------
	 

	 @Override
	 public boolean onCreateOptionsMenu(Menu menu) 
		{
			MenuInflater inflater = getMenuInflater();
			inflater.inflate(R.menu.menu_datos, menu);
			return true;
		}
		@Override
	    public boolean onOptionsItemSelected(MenuItem item) 
		{
	        switch (item.getItemId()) 
	        {
	        	case R.id.Opc1:
	        		//crear alerta
	            	Toast.makeText(getApplicationContext(), "Crear alerta", Toast.LENGTH_LONG).show();
	            	Intent a=new Intent(Datos.this, CrearAlerta.class);
	         	   	startActivity(a);
	         	   	//finish();
	         	   	return true;
	            	
	            case R.id.Opc2:
	            	Toast.makeText(getApplicationContext(), "Monitorear alerta", Toast.LENGTH_LONG).show(); 
	            	Intent b=new Intent(Datos.this, VerAlertas.class);
	         	   	startActivity(b);
	         	   	//finish();
	         	   	return true;
	         	   	
	            case R.id.Opc3:	            	
	            	//cerrar  sesion nos regresa a la ventana anterior. 
	            	Toast.makeText(getApplicationContext(), "Cerrando Sesion de "+usuario, Toast.LENGTH_LONG).show();
	         	   	Intent c=new Intent(Datos.this, Login.class);
	         	   	startActivity(c);
	         	   	finish();
	         	   	return true;
	            	
	            default:
	                return super.onOptionsItemSelected(item);
	        }
	    }
		//--------- menu ----------------------------
	 
	 
}//class


