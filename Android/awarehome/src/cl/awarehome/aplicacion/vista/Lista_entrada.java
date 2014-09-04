package cl.awarehome.aplicacion.vista;

public class Lista_entrada {
	private int idImagen; 
	private String textoEncima; 

	public Lista_entrada (int idImagen, String textoEncima) { 
	    this.idImagen = idImagen; 
	    this.textoEncima = textoEncima; 
	}

	public String get_textoEncima() { 
	    return textoEncima; 
	}

	public int get_idImagen() {
	    return idImagen; 
	} 

}
