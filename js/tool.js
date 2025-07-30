
export async function mostrarVista(url) {
    // Esta función obtiene el contenido HTML de la vista especificada
    try {
        const res = await fetch(url);
        if (!res.ok) {
            throw new Error(`Error al cargar la vista: ${res.statusText}`);
        }
        const data = await res.text();
        //console.log("Datos recibidos de la vista:", data);
        return data;
    } catch (err) {
        return `
            <div class="text-red-500 text-center">
                <p>Error al cargar la información. Por favor, inténtalo más tarde.</p>
            </div>
        `;
    }
    
}
