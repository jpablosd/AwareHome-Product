package cl.awarehome.aplicacion.vista;

import java.util.ArrayList;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

public abstract class Lista_Adaptador extends BaseAdapter{

    private ArrayList<?> entradas; 
    private int R_layout_IdView; 
    private Context contexto;
    
    
    public Lista_Adaptador(Context contexto, int R_layout_IdView, ArrayList<?> entradas) {
        super();
        this.contexto = contexto;
        this.entradas = entradas; 
        this.R_layout_IdView = R_layout_IdView; 
    }
	
	
	@Override
	public int getCount() {
		return entradas.size();
	}

	@Override
	public Object getItem(int position) {
		return entradas.get(position);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(int position, View view, ViewGroup parent) {
		if (view == null) {
		    LayoutInflater vi = (LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE); 
	            view = vi.inflate(R_layout_IdView, null); 
	        }
	        onEntrada (entradas.get(position), view);
	        return view; 
	}
	
	public abstract void onEntrada (Object entrada, View view);

}
