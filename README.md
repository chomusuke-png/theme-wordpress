# Manual de Usuario: CHISI Theme

**Versión del Tema:** 1.9.1
**Descripción:** Plantilla personalizada para camara de comercio CHISI.
**Autor:** Zumito

## Introducción
**CHISI** es un tema corporativo elegante que utiliza tonos dorados/mostaza y fondos perla. Está diseñado para resaltar la captación de socios ("Hazte Miembro") y organizar grandes cantidades de información mediante widgets y categorías automatizadas.

## Características Clave
* **Cabecera Funcional:** Incluye buscador central, botón de acción destacado y un menú de redes sociales desplegable.
* **Portada Automatizada:** Carrusel de últimas noticias y grilla de categorías destacadas que se generan solas.
* **Doble Zona de Widgets en Home:** Una zona para contenido estándar y otra "Raw" para mapas o iframes de ancho completo.
* **Diseño de Lectura:** Artículos con cabeceras inmersivas (con imagen de fondo) o limpias (modo oscuro).

# Configuración Básica

Dirígete a **Apariencia > Personalizar** para ajustar los elementos globales del sitio.

## 1. Botón de Cabecera ("Hazte Miembro")
En la esquina superior derecha aparece un botón dorado de llamada a la acción.
* **Ubicación:** Panel *Configuración General*.
* **Texto del Botón:** Define el texto (ej: "Hazte Miembro" o "Portal Socios"). Por defecto es "Hazte Miembro".
* **Enlace:** URL a la que dirigirá el botón (ej: `/hazte-miembro`).

## 2. Redes Sociales (Menú "REDES")
El tema no muestra los iconos sociales dispersos, sino agrupados en un botón desplegable circular llamado **"REDES"** en la cabecera.
* **Ubicación:** Panel *Redes Sociales*.
* **Gestión:** Utiliza un sistema de "Repetidor".
    * Haga clic en "Añadir red social".
    * **Título:** Nombre de la red (aparece al pasar el mouse).
    * **Icono:** Seleccione de la lista (Facebook, Instagram, WhatsApp, TikTok, Email, Ubicación, X, YouTube).
    * **URL:** Enlace a su perfil.
* **Visualización:** Al hacer clic en el botón "REDES" en la web, se despliega una tira vertical con los iconos configurados.

## 3. Footer: Sitios Relacionados
Similar a las redes sociales, pero ubicado en el pie de página para enlaces institucionales.
* **Ubicación:** Panel *Sitios Relacionados (Footer)*.
* **Iconos Disponibles:** Noticia, Empresa, Globo (Web).

## 4. Cantidad de Artículos
En *Configuración General*, puedes definir cuántos artículos se muestran en las páginas de archivo y búsqueda (por defecto 10).

# Portada Automática

La página de inicio (`index.php`) está diseñada para "funcionar sola" con el contenido que publicas, reduciendo la necesidad de configuración manual.

## 1. Hero Slider (Carrusel Principal)
* **Funcionamiento:** Muestra automáticamente las **3 últimas entradas** publicadas.
* **Requisito:** Las entradas deben tener una **Imagen Destacada** para que se vea el fondo.
* **Contenido:** Muestra el título y un botón "Leer más".
* **Nota:** Ignora los posts fijados (sticky posts) para mantener la frescura del contenido.

## 2. Categorías Destacadas
Debajo del slider, el tema muestra automáticamente 4 tarjetas de categorías.
* **Lógica de Selección:** Elige las 4 categorías con **mayor cantidad de artículos**.
* **Imagen de Fondo:** El tema busca el último artículo publicado en esa categoría y usa su imagen destacada como fondo de la tarjeta.
* **Datos:** Muestra el nombre de la categoría y el contador de artículos (ej: "12 Artículos").
* **Acción:** Al hacer clic, lleva al archivo de esa categoría.

> **Consejo:** Para que esta sección luzca bien, asegúrese de que sus artículos más recientes tengan siempre imágenes de buena calidad.

# Áreas de Widgets

El tema cuenta con zonas de widgets muy específicas gestionables desde **Apariencia > Widgets**.

## 1. Home Widgets (Estándar)
* **ID:** `home-widgets`
* **Ubicación:** En la portada, debajo de las categorías destacadas.
* **Estilo Visual:** Cada widget agregado aquí tendrá automáticamente:
    * Fondo blanco.
    * Sombra suave.
    * Borde redondeado.
    * Título color mostaza con subrayado.
* **Uso Recomendado:** Listas de texto, imágenes promocionales, calendarios.

## 2. Home Widgets (Raw / Sin Estilos)
* **ID:** `home-widgets-raw`
* **Ubicación:** Debajo de la zona estándar, al final del cuerpo de la portada.
* **Estilo Visual:** **Sin estilos**. No tiene fondo, ni padding, ni bordes. Ocupa el ancho disponible del contenedor.
* **Uso Recomendado:**
    * Mapas de Google (iframe).
    * Scripts de terceros (clima, bolsa).
    * Banners de publicidad que ya traen su propio diseño.
    * *Nota:* El título del widget se oculta visualmente en esta zona para mayor limpieza.

## 3. Footer Widget Principal
* **ID:** `footer-widget-main`
* **Ubicación:** Centro del pie de página.
* **Estilo:** Texto claro sobre fondo oscuro. Ideal para información de contacto o dirección.

# Menús y Navegación

## Menú Principal
* **Ubicación:** `main_menu`.
* **Diseño:** Barra blanca debajo de la cabecera principal.
* **Comportamiento:**
    * Los submenús se despliegan al pasar el mouse.
    * Indica la página activa con una línea inferior dorada (`#947e1e`).

## Widget en la Barra de Navegación
Una característica única de este tema es la capacidad de insertar un widget directamente *dentro* de la barra de menú horizontal.

* **ID:** `navbar-widget`
* **Ubicación:** Se renderiza como el **último elemento (a la derecha)** de la barra de navegación.
* **Uso Ideal:** Plugins de traducción (ej: GTranslate) o selectores de moneda.
* **Nota Técnica:** El tema envuelve este widget en una etiqueta `<li>`, por lo que se integra perfectamente con la lista del menú.

## Buscador Central
En la cabecera principal siempre aparece un buscador en forma de "píldora".
* Este buscador está configurado para mostrar solo resultados de **Entradas** y **Páginas**, filtrando otros tipos de contenido innecesario.