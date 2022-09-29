""" 
Importar la biblioteca
Para acceder a los métodos de Pandas es necesario importar la biblioteca:
import pandas 
Ahora que el módulo ha sido importado puedes llamar a sus atributos. Esto facilitará las llamadas repetidas al módulo.
import pandas as pd 
Preparar los datos
Queremos convertir los datos en una tabla. Para ello llamaremos a la clase DataFrame().
DataFrame() toma dos argumentos:
Una lista que contiene datos
Los nombres de las columnas de la tabla
Creemos un dataset sencillo. La variable atlas almacena una lista de listas con los nombres de los países y sus capitales:
atlas = [  
    ['France', 'Paris'], 
    ['Russia', 'Moscow'], 
    ['China', 'Beijing'], 
    ['Mexico', 'Mexico City'], 
    ['Egypt', 'Cairo'] 
] 

['Bob Dylan','Like A Rolling Stone']
['John Lennon','Imagine']
['The Beatles','Hey Jude']
['Nirvana','Smells Like Teen Spirit']

Ahora creemos una tabla con estos datos.
Crearemos una variable que se pasará como segundo argumento. En ella se almacenarán los nombres de las columnas country y capital:
# "geography" es 'geografía' en español
geography = ['country', 'capital'] 
Ahora tenemos dos argumentos para el DataFrame().
Crear una tabla
world_map = pd.DataFrame(data=atlas, columns=geography) 
Como DataFrame() está en la biblioteca Pandas, está precedido por pd cuando lo llamamos.
image
import pandas as pd

# preparando los datos y los nombres de las columnas

atlas = [
    ['Francia', 'París'], 
    ['Rusia', 'Moscú'], 
    ['China', 'Pekín'], 
    ['México', 'Ciudad de México'], 
    ['Egipto', 'Cairo'] 
]
geography = ['country', 'capital']

# creando una tabla

world_map = pd.DataFrame(data=atlas , columns=geography) # creando una tabla y almacenándola en la variable world_map

print(world_map) # mostrando la tabla 
       country           capital
0  Francia             París
1    Rusia             Moscú
2    China             Pekín
3   México  Ciudad de México
4   Egipto             Cairo 

"""


'''
Recuperación de datos
En la lección anterior preparaste los datos de una tabla por ti mismo pero los datos generalmente se almacenan en un archivo con una estructura específica que primero debe ser convertida en un objeto de tipo DataFrame.
En este programa, se tratará principalmente con archivos CSV (comma-separated value por sus siglas en inglés) aunque también habrá algunos archivos de Excel. En el curso de introducción se leyeron los datos de los archivos CSV. ¿Recuerdas el método que utilizaste?
Para leer un CSV, tenemos que llamar...


listCSV()

toCSV()

Respuesta correcta
read_csv()
Sí, este método convierte los datos del archivo en un DataFrame.
Como hemos comentado anteriormente, el DataFrame necesita datos y nombres de columnas y los archivos CSV proporcionan ambos componentes:
La primera línea almacena los nombres de las columnas
Cada línea siguiente corresponde a una fila de la tabla
En los archivos CSV, las comas (u otros separadores) separan los valores de las diferentes columnas. Pandas lee estos archivos y transfiere los datos a una tabla:
image
Lectura del archivo
Analicemos de nuevo la sintaxis de read_csv(). A menudo solo se necesita un argumento, la ruta del archivo:
import pandas as pd
df = pd.read_csv('/datasets/music_log.csv') # argumento es una ruta de archivo 
La ruta del archivo es una string que indica dónde está almacenado el archivo. La ruta puede ser diferente dependiendo de dos factores:
El sistema operativo que determina su forma.
En Windows, la ruta suele escribirse con una barra invertida: 'C:\catalog\file.csv'.
En macOS y Linux, se escribe con una barra diagonal: '/catalog/files.csv'.
Si la ruta es relativa o absoluta.
Una ruta absoluta se ejecuta a partir del directorio superior del sistema. En Windows, es el nombre del disco ("C"): 'C:\catalog\file.csv'. En Linux y macOS, la ruta se ejecuta con una "raíz" indicada por una barra antes de su nombre: '/catalog/file.csv'.
Una ruta relativa se refiere a una ubicación que es relativa al directorio actual. Por ejemplo, si un programa y un archivo se ejecutan desde el mismo directorio, la ruta será solo el nombre del archivo. Si un programa se ejecuta desde un directorio superior, la ruta relativa incluirá el nombre de un subdirectorio donde se encuentre el archivo:
image
Ahora volvamos a la llamada read_csv:
df = pd.read_csv('/datasets/music_log.csv') # argumento es una ruta de archivo 
¿Para qué sistema operativo es el código anterior?


Respuesta correcta
El código es seguramente para macOS o Linux
Así es. Probablemente puedas imaginar en qué sistema operativo funciona la plataforma Practicum. Sus rutas de archivos se escriben con /. Una pista: ya no se crean servidores en macOS.

Esta ruta es para Windows
¿Qué más puedes decir sobre la ruta: '/datasets/music.csv'?


Respuesta correcta
Es una ruta absoluta.
Esta comienza con la raíz: /.

Es una ruta relativa.
Ahora ya conoces dos formas de crear un DataFrame:
Recopilarlo a partir de listas directamente en el código
Leer un archivo CSV utilizando las herramientas incorporadas de Pandas
¿Por qué es importante? Porque ahora podemos utilizar las funciones de análisis incorporadas de DataFrame() que veremos en la próxima lección.
'''

'''
Obtener una visión general de los datos
Recuerda que el primer paso para familiarizarse con los datos es mostrar las primeras o últimas filas de una tabla.
¿Qué comando mostrará las 5 primeras filas de la tabla data_df?


data_df.head(print)

print(data_df)

Respuesta correcta
print(data_df.head())
Así es. El método head() pasa las cinco primeras filas a la función print() que las muestra en la pantalla.
Para cambiar el número de filas a mostrar pasa el número deseado al método como argumento adicional. Por ejemplo, head(10) devolverá las 10 primeras filas.
El método tail() devolverá las últimas filas de la tabla.
Los métodos tail() y head() pueden ayudarte a tener una perspectiva general de los datos sin tener que mostrar toda la tabla.
Sin embargo, la primera impresión puede ser falsa por lo que a menudo hay que analizar más a fondo. Cosas que pueden ayudarte a comprender mejor:
Conocimiento de la estructura de un DataFrame
Acceso a la documentación sobre el dataset
Comprobación de los atributos que almacenan los metadatos del DataFrame
Estructura del DataFrame
Un DataFrame es una estructura de datos bidimensional de Pandas en la que cada elemento tiene dos coordenadas: una fila y una columna. Normalmente se accede a las filas por los índices y a las columnas por sus nombres:
image
Cada fila es una única observación, una entrada sobre los datos en cuestión. Las columnas son las características del objeto. Por ejemplo, cuando un usuario reproduce una canción aparece una nueva fila en la tabla. Las características de este nuevo evento se agregan a cada columna: en nuestro caso, nombre de la canción, duración y artista.
Documentación para los datos
Los nombres de las columnas te ayudan a navegar por los datos. Son similares a los nombres de las variables en cuanto a que indican qué tipo de datos hay detrás de todos esos números y filas de la tabla. Pero los nombres de las columnas no lo dicen todo.
Por ejemplo, el nombre total play sugiere que la columna almacena la duración total de la canción. Pero esto puede medirse en segundos o minutos. Incluso puede incluir la duración de un anuncio que se reproduce antes de la canción.
Hay dos maneras de aclarar estos detalles:
Busca la documentación con la descripción de cada columna
Pregunta a un compañero
La documentación suele ser la opción preferida. Una documentación bien redactada describe la estructura de los datos y proporciona ejemplos de su uso. La descripción de la columna sería algo así:
user_id — identificador único de usuario
total play — el tiempo (en segundos) que el usuario reprodujo la canción
Artist — nombre del artista
genre — género (rock, pop, electrónica, clásica, etc.)
track — nombre de la canción
Pero la documentación puede resultar obsoleta, mal diseñada o irrelevante para una tarea concreta. En ese caso, sin duda necesitarás el consejo de un compañero de trabajo experimentado.
Atributos del DataFrame
Un DataFrame almacena tanto datos como información general sobre ellos (en forma de atributos). Aquí hay algunos ejemplos:
dtypes — tipos de valores de columnas
columns — nombres de columnas
shape — tamaño de la tabla
El acceso a los diferentes atributos da una perspectiva de toda la tabla. En los próximos capítulos, verás cómo los atributos te ayudan a encontrar y corregir rápidamente ciertas fallos en el DataFrame.
Llamar a un atributo es como llamar a un método excepto que el atributo no va seguido de paréntesis (df.attribute versus df.method()).
dtypes
Una columna puede contener valores de diferentes tipos. El atributo dtypes te indicará cuáles son.
print(df.dtypes) 
image
Pandas tiene sus propios tipos de datos. Cada uno corresponde a un determinado tipo de datos en Python:
_	Tipo "Python"	Tipo "pandas"
string	str	object
integer	int	int64
floating-point number	float	float64
logical data type	bool	bool
Nota: en Pandas, object puede indicar strings o datos que no entran en ningún otro tipo.
Nombres de columnas
El atributo columns almacena una lista que contiene los nombres de las columnas, cada una de las cuales es de tipo object (string):
print(df.columns) 
image
Tamaño de la tabla
Si quieres saber el tamaño de una tabla utiliza el atributo shape. Almacena una tupla (más sobre esto en un minuto). El primer valor de la tupla es el número de filas y el segundo es el número de columnas:
print(df.shape) 
image
La tabla tiene 67.963 filas y cinco columnas.
Las tuplas son similares a las listas, pero:
A diferencia de las listas, las tuplas se colocan entre paréntesis
Los elementos de la lista pueden modificarse, agregarse o eliminarse mientras que las tuplas son inmutables, es decir, no pueden modificarse
Recuperar un valor de una tupla es tan fácil como con las listas:
# obtener el número de filas de la tupla
rows_number = df.shape[0]

# obtener el número de columnas de la tupla
columns_number = df.shape[1] 
Solicitar todos los atributos con info()
Puedes acceder a cada atributo de la tabla por separado, pero también puedes solicitarlos todos a la vez. Simplemente llama al método info():
df.info() 
<class 'pandas.core.frame.DataFrame'>
RangeIndex: 67963 entries, 0 to 67962
Data columns (total 5 columns):
user_id     67963 non-null object
total play    67963 non-null float64
Artist        60157 non-null object
genre         65223 non-null object
track         65368 non-null object
dtypes: float64(1), object(4)
memory usage: 2.6+ MB 
image
La familiarización con los datos suele iniciar con una llamada a info(). Estudia los resultados y elige una estrategia para procesar la tabla.
Por ejemplo, en nuestro caso diferentes columnas tienen diferentes números de elementos que no son nulos:
Artist — 60157
genre — 65223
track — 65368
Esto significa que cada una de estas columnas contiene valores nulos o ausentes. Hay que procesarlas antes de pasar a analizar los datos. Este tipo de conclusiones no pueden obtenerse solo estudiando el resultado de head().
El preprocesamiento de datos, que implica el tratamiento de los valores ausentes, es una parte interesante del trabajo con datos. Hablaremos de ello en el próximo capítulo.
Pero primero, un poco de práctica trabajando con los atributos de un DataFrame. Vamos a familiarizarnos con los datos que nos ha enviado Y.Music.
'''














""" 
Indexación de un DataFrame
Ahora que sabes cómo obtener información general sobre las tablas, es momento de que aprendas algunas técnicas básicas para recuperar datos específicos de ellas.
Muchas veces solo necesitarás una pequeña cantidad de datos para resolver una tarea. Por ejemplo, si buscases propiedades más baratas que estuvieran por debajo de los 8 000 dólares crearías un filtro:
import pandas as pd
properties_df = pandas.read_csv('/datasets/properties_us.csv')

filtered_objects = []

for index in range(len(properties_df)):
    if properties_df['price'][index] <= 8000:
        filtered_objects.append(properties_df['price'][index])
        
print(len(filtered_objects)) 
Resultado
292 
Esta solución es correcta, pero ahora aprenderemos a acelerar el proceso. Estas cinco líneas de código pueden convertirse en una:
import pandas
properties_df = pandas.read_csv('/datasets/properties_us.csv')

print(properties_df[properties_df['price'] <= 8000]['price'].count()) 
Resultado
292 
Este código es más preciso: no tiene bucles, condiciones ni variables vacías de filtered_objects. Se han sustituido por una sola herramienta: indexación.
Indexación por coordenadas
La indexación consiste en acceder a una celda de la tabla utilizando dos coordenadas: el número de fila y el nombre de la columna.
La indexación podría parecer difícil, pero con el tiempo y la práctica se convertirá en algo sencillo.
Puedes acceder a los índices con la ayuda del atributo loc[]: loc[row, column].
Podemos obtener el contenido de la celda de la quinta fila y de la columna genre:
image
Código
PYTHON
1
import pandas as pd
2
​
3
df = pd.read_csv('/datasets/music_log.csv')
4
​
5
result = df.loc[4, 'genre']
6
print(result)
Resultado
pop
La indexación comienza con 0, como siempre.
Es posible solicitar celdas separadas así como grupos de celdas mediante la indexación. Por ejemplo, puedes acceder a:
Todas las celdas de una fila determinada
Todas las celdas de varias filas
Todas las celdas de un segmento de filas
image
Se indica el principio y el final de un segmento, separándolos con : y se obtienen todos los valores entre ellos.
¡Importante! A diferencia de las listas, los límites de los rangos también llegan al segmento de filas. La solicitud df.loc[2:4] devolverá las filas con los índices 2, 3 y 4.
La indexación de columnas funciona de la misma manera. También puedes acceder a una lista de columnas:
image
Aquí hay otros ejemplos de indexación:
Type	Sample
Una celda	.loc[7, 'genre']
Una columna	.loc[:, 'genre']
Varias columnas	.loc[:, ['genre', 'Artist']]
Múltiples columnas consecutivas (un slice)	.loc[:, 'user_id': 'genre']
Una fila	.loc[1]
Todas las filas a partir de la fila dada	.loc[1:]
Todas las filas hasta la fila dada	.loc[:3]
Múltiples filas consecutivas (un slice)	.loc[2:5]
Observa cómo funciona la indexación en Pandas. Elimina # para descomentar cualquiera de las líneas y ejecutar el código. La indexación puede tardar entre 10 y 15 segundos.
Código
PYTHON
1
import pandas as pd
2
​
3
df = pd.read_csv('/datasets/music_log.csv')
4
# obteniendo una celda
5
# index_res = df.loc[7, 'genre']
6
​
7
# segmentando una columna
8
# index_res = df.loc[:, 'genre']
9
​
10
# segmentando varias columnas por sus nombres
11
index_res = df.loc[: , ['genre', 'Artist']]
12
​
13
# segmentando un rango de columnas
14
# index_res = df.loc[:, 'total play': 'genre']
15
​
16
# segmentando una fila
17
# index_res = df.loc[1]
18
​
19
# segmentando todas las filas, empezando por la fila dada
20
# index_res = df.loc[1:]
21
​
22
# segmentando todas las filas hasta la fila dada
23
# index_res = df.loc[:3]
24
​
25
# segmentando varias filas consecutivas 
26
# index_res = df.loc[2:5]
27
​
28
print(index_res)
Resultado
                genre                                  Artist
0                 pop                              Marina Rei
1             ambient                            Stive Morgan
2             ambient                            Stive Morgan
3               dance                                     NaN
4                 pop                                  Rixton
5                jazz  Henry Hall & His Gleneagles Hotel Band
6        classicmetal                                     NaN
7          electronic                                     NaN
8                 pop                   Andrew Paul Woodworth
9               indie                            Pillar Point
10               jazz                          Steve Campbell
11                pop                            David Civera
12             hiphop                            Lumipa Beats
13                pop                         Henning Wehland
14                NaN                                     NaN
15             spoken                            Пётр Каледин
16              dance                                ChinKong
17                pop                               Albatraoz
18              dance                              Pugs Atomz
19              dance                               Zak Moore
20                new                         Kendra Springer
21              latin                        Nathalie Cardone
22              dance                                 Snowday
23              indie                                  Swords
24       extrememetal                     Montezuma's Revenge
25              dance                                     NaN
26                NaN                                     NaN
27       instrumental                     Музыка для изучения
28              dance                                  A-Life
29          classical                          Peter Holzmann
...               ...                                     ...
67933          hiphop                                   Yanix
67934            rock                                   Arena
67935            punk                           Sleaford Mods
67936           urban                        Gabriela Tristan
67937             pop                                Dom Blvd
67938       classical                           Ched Tolliver
67939           indie                                    Porn
67940           dance                                  Kultur
67941            rock                              Duane Eddy
67942            rock                                 Icefish
67943           local                           1/2 Orchestra
67944         russian                            Марат Крымов
67945          hiphop                                   Losty
67946  argentinetango                             Las Sombras
67947       classical                      Alfredo Bernardini
67948       downtempo                              Contraband
67949      electronic                           George Whyman
67950           dance                                     NaN
67951           dance                             Julien Mier
67952             pop                    Bierstrassen Cowboys
67953            folk                             Flip Grater
67954          trance                                 Alt & J
67955            rock                                     TKN
67956           dance                                   89ers
67957          reggae                             Steel Pulse
67958             pop                            Nadine Coyle
67959           dance                            Digital Hero
67960           metal                                 Red God
67961             pop                            Less Chapell
67962             NaN                                     NaN

[67963 rows x 2 columns]
Puedes segmentar simultáneamente por un número de fila y una lista de columnas:
Type	Sample
Segmentando filas dentro del rango dado y seleccionando una columna determinada	.loc[2:10, 'genre']
Segmentando varias columnas consecutivas y seleccionando una fila determinada	.loc[5, 'total play': 'genre']
Seleccionando las columnas dadas y una fila determinada	.loc[10, ['total play', 'Artist']]
Seleccionando las columnas dadas y segmentando múltiples filas consecutivas	.loc[7:10, ['total play', 'genre']]
Prueba y experimenta:
Código
PYTHON
1
import pandas as pd
2
​
3
df = pd.read_csv('/datasets/music_log.csv')
4
​
5
# Segmentando filas dentro del rango dado y seleccionando una determinada columna
6
index_res = df.loc[2:10, 'genre']
7
​
8
# Segmentando varias columnas consecutivas y seleccionar una fila determinada
9
# index_res = df.loc[5, 'total play': 'genre']
10
​
11
# Seleccionando las columnas dadas y una determinada fila
12
# index_res = df.loc[10, ['total play', 'Artist']]
13
​
14
# Seleccionando las columnas dadas y segmentando múltiples filas consecutivas
15
# index_res = df.loc[7:10, ['total play', 'genre']]
16
​
17
print(index_res)
Resultado
2          ambient
3            dance
4              pop
5             jazz
6     classicmetal
7       electronic
8              pop
9            indie
10            jazz
Name: genre, dtype: object
Entrenamiento de batalla
¿Recuerdas el clásico juego de mesa Battleship? Es ideal para practicar las habilidades de indexación. Podemos representar el campo de juego en forma de tabla:
'Х' significará golpes
'-' significará fallos
0 representará las celdas sin tocar
image
import pandas as pd

board = [[0,0,0,0,0,0,0,0,0,0],
        [0,'-','-','-',0,0,0,0,0,0],
        [0,'-','X','-',0,0,'X','X','X','X'],
        [0,'-','X','-',0,0,0,0,0,0],
        [0,'-','-','-',0,0,0,0,0,0],
        [0,0,'-',0,0,0,0,0,'X',0],
        [0,'-','X','X',0,0,0,0,0,0],
        [0,0,'-','-',0,0,0,0,0,0],
        [0,0,0,0,'-','X',0,0,0,0],
        [0,0,0,0,0,0,0,0,0,0]]

column_names = ['A','B','C','D','E','F','G','H','I','J']

battle = pd.DataFrame(data=board, columns=column_names)

print(battle) 
     A  B  C  D  E  F  G  H  I  J
0  0  0  0  0  0  0  0  0  0  0
1  0  -  -  -  0  0  0  0  0  0
2  0  -  X  -  0  0  X  X  X  X
3  0  -  X  -  0  0  0  0  0  0
4  0  -  -  -  0  0  0  0  0  0
5  0  0  -  0  0  0  0  0  X  0
6  0  -  X  X  0  0  0  0  0  0
7  0  0  -  -  0  0  0  0  0  0
8  0  0  0  0  -  X  0  0  0  0
9  0  0  0  0  0  0  0  0  0  0 
Supongamos que queremos hacernos una idea de la situación en el tablero sin mostrarlo todo.
Podemos empezar con una columna. Mostraremos C::
print(battle.loc[:,'С']) 
0    0
1    -
2    X
3    X
4    -
5    -
6    X
7    -
8    0
9    0 
En la séptima fila (con el índice 6) vemos un barco que ha sido golpeado pero aún no ha sido hundido. Los disparos a las celdas de arriba y abajo fueron fallidos. Así podemos suponer que el barco está situado en posición horizontal. Veamos si estamos en lo cierto mostrando la séptima fila:
print(battle.loc[6]) 
A    0
B    -
C    X
D    X
E    0
F    0
G    0
H    0
I    0
J    0 
En efecto, el barco está posicionado horizontalmente (en las columnas C y D). Ya ha recibido dos golpes en las columnas C y D.
Alejémonos un poco para tener un poco de perspectiva. Mostramos las filas sexta a octava.
print(battle.loc[5:7]) 
     A  B  C  D  E  F  G  H  I  J
5  0  0  -  0  0  0  0  0  X  0
6  0  -  X  X  0  0  0  0  0  0
7  0  0  -  -  0  0  0  0  0  0 
La siguiente coordenada a golpear es evidentemente la de índice 6 y columna E.
¡Bien hecho, Almirante!
Notación abreviada para la indexación
En la práctica, la notación abreviada se utiliza habitualmente para la indexación. A pesar de sus capacidades más limitadas. En este caso, en lugar de llamar al atributo loc[], coloca los índices dentro de corchetes justo después de la variable:
Type	Sample	Shortened notation
Una celda	.loc[7, 'genre']	-
Una columna	.loc[:, 'genre']	df['genre']
Varias columnas	.loc[:, ['genre', 'Artist']]	df [['genre', 'Artist']]
Múltiples columnas consecutivas (un slice)	.loc[:,'total play': 'genre']	-
Una fila	.loc[1]	-
Todas las filas a partir de la fila dada	.loc[1:]	df[1:]
Todas las filas hasta la fila dada	.loc[:3] incluyendog 3	df[:3] sin incluir 3
Múltiples filas consecutivas (un slice)	.loc[2:5] incluyendo 5	df[2:5] sin incluir 5
Como puedes ver en la tabla, la indexación en notación abreviada funciona de forma un tanto diferente:
Los segmentos no incluyen el final del rango
No puedes dirigirte a una sola celda o fila
En la siguiente lección, explicaremos por qué es así.
Para ver cómo funciona la notación abreviada loc[], descomenta cada línea por separado y ejecuta el código:
Código
PYTHON
1
import pandas as pd
2
​
3
df = pd.read_csv('/datasets/music_log.csv')
4
​
5
# segmentando una columna
6
# index_res = df['genre']
7
​
8
# segmentando varias columnas por sus nombres
9
index_res = df[['genre', 'Artist']]
10
​
11
# segmentando todas las filas a partir de la fila dada
12
# index_res = df[1:]
13
​
14
# segmentando todas las filas hasta la fila dada
15
# index_res = df[:3]
16
​
17
# segmentando varias filas consecutivas
18
# index_res = df[2:5]
19
​
20
print(index_res)
Resultado
                genre                                  Artist
0                 pop                              Marina Rei
1             ambient                            Stive Morgan
2             ambient                            Stive Morgan
3               dance                                     NaN
4                 pop                                  Rixton
5                jazz  Henry Hall & His Gleneagles Hotel Band
6        classicmetal                                     NaN
7          electronic                                     NaN
8                 pop                   Andrew Paul Woodworth
9               indie                            Pillar Point
10               jazz                          Steve Campbell
11                pop                            David Civera
12             hiphop                            Lumipa Beats
13                pop                         Henning Wehland
14                NaN                                     NaN
15             spoken                            Пётр Каледин
16              dance                                ChinKong
17                pop                               Albatraoz
18              dance                              Pugs Atomz
19              dance                               Zak Moore
20                new                         Kendra Springer
21              latin                        Nathalie Cardone
22              dance                                 Snowday
23              indie                                  Swords
24       extrememetal                     Montezuma's Revenge
25              dance                                     NaN
26                NaN                                     NaN
27       instrumental                     Музыка для изучения
28              dance                                  A-Life
29          classical                          Peter Holzmann
...               ...                                     ...
67933          hiphop                                   Yanix
67934            rock                                   Arena
67935            punk                           Sleaford Mods
67936           urban                        Gabriela Tristan
67937             pop                                Dom Blvd
67938       classical                           Ched Tolliver
67939           indie                                    Porn
67940           dance                                  Kultur
67941            rock                              Duane Eddy
67942            rock                                 Icefish
67943           local                           1/2 Orchestra
67944         russian                            Марат Крымов
67945          hiphop                                   Losty
67946  argentinetango                             Las Sombras
67947       classical                      Alfredo Bernardini
67948       downtempo                              Contraband
67949      electronic                           George Whyman
67950           dance                                     NaN
67951           dance                             Julien Mier
67952             pop                    Bierstrassen Cowboys
67953            folk                             Flip Grater
67954          trance                                 Alt & J
67955            rock                                     TKN
67956           dance                                   89ers
67957          reggae                             Steel Pulse
67958             pop                            Nadine Coyle
67959           dance                            Digital Hero
67960           metal                                 Red God
67961             pop                            Less Chapell
67962             NaN                                     NaN

[67963 rows x 2 columns]
Indexación lógica (booleana)
La indexación puede ser más eficaz si también se utiliza una expresión lógica.
Recuerda cómo escribiste los filtros y contadores sin Pandas:
Hiciste un bucle a partir de una lista anidada
Comprobaste si la condición se había cumplido utilizando if, almacenando las filas correspondientes en una variable y/o aumentando el valor del contador
En Pandas, este complicado algoritmo puede llevarse a cabo en una línea de código. El procedimiento se denomina lógico o indexación booleana.
Primero, encontraremos todas las filas en las que 'X' aparece en la columna C.
battle.loc[:,'C'] == 'X'
Hemos agregado una expresión lógica a la indexación habitual.
Ahora podemos utilizar esta expresión como argumento para otra llamada a loc[].
battle.loc[battle.loc[:,'C'] == 'X']
De izquierda a derecha: estamos solicitando a Pandas que mire al Data Frame battle y nos dé todas las filas de battle en las que la columna C sea igual a 'X'.
En conjunto, estas dos expresiones devolverán tres filas:
     A  B  C  D  E  F  G  H  I  J
2  0  -  X  -  0  0  X  X  X  X
3  0  -  X  -  0  0  0  0  0  0
6  0  -  X  X  0  0  0  0  0  0 
Escribir el contador no será tan difícil. Vamos a encontrar el número de celdas con el valor 'X' en la columna C. Primero, necesitaremos obtener estas celdas:
image
Para contar las celdas resultantes llamaremos al método count():
print(battle.loc[battle.loc[:,'C'] == 'X']['C'].count()) 
3 
count() es una herramienta muy útil para una tarea tan pequeña, pero definitivamente la necesitarás para analizar tablas con miles de filas.
La indexación lógica también ha reducido la notación. Así, el código anterior tendrá el siguiente aspecto:
print(battle[battle['C'] == 'X']['C'].count()) 
Esta forma de indexación lógica es muy común.
Aquí puedes utilizar expresiones lógicas con cualquier operación lógica: ==, !=, >, <, >=, <=, así como funciones de primer orden (que devuelven los valores lógicos True o False).
Intenta un poco de indexación lógica:
Código
PYTHON
1
import pandas as pd
2
​
3
df = pd.read_csv('/datasets/music_log.csv')
4
# filas, donde el género es el jazz
5
jazz_df = df[df['genre'] == 'jazz']
6
print(jazz_df)
7
​
8
# filas en las que el total de reproducciones es superior a 90
9
high_total_play_df = df[df['total play'] > 90] 
10
print(high_total_play_df)
11
​
12
# filas en las que el total de reproducciones es menor o igual a 10
13
low_total_play_df = df[df['total play'] <= 10]
14
print(low_total_play_df)
Resultado
        user_id  ...                                              track
5      4166D680  ...                                               Home
10     D3DD8D00  ...                                        Morning Dew
77     9AE82E5C  ...                                     Cumbia Cha Cha
94     A2CC841A  ...                                             Intuit
126    C31591B3  ...                           The Shadow of Your Smile
150    3EC23561  ...                                             Slinky
182    C31591B3  ...                               Shadow of Your Smile
184    E2758511  ...                              In the Chains of Fate
202    AAA0FFE6  ...                            How Do I Know It's Real
223    52796231  ...                               Open Dialogues Suite
292    A062B34E  ...                              Shingaling Shingaling
298    DE584C50  ...                                    How insensitive
326    CE3EF9F3  ...                             Gotta See Baby Tonight
337    516E1B6E  ...                                       Sister Sadie
348    DEB20566  ...                           The Captain of Her Heart
384    7EB5C3DD  ...                                         Syl-O-Gism
400    BA0C0137  ...                                      Close To Home
406    7F77F050  ...                                                NaN
419    BB8802D4  ...                                            Move On
495     D90DEA2  ...                                     Man from Uncle
571    C7F5A17E  ...                                I Like It Like That
575    2FD78AE3  ...                                              Frevo
580    6D04268A  ...                                     You Never Know
602     3420F04  ...    One For My Baby (as made famous by The Crooner)
628    FF7AEFB4  ...                                                NaN
667    BB8802D4  ...                                          Ineffable
681    AADB7032  ...                         Just a Fair Weather Friend
752    4326B014  ...                            Come Rain Or Come Shine
816    F8677C77  ...            Praise The Lord And Pass The Ammunition
822    C7B8E8C6  ...                          Snuggled on Your Shoulder
...         ...  ...                                                ...
67065  7AE86D95  ...                                           Hot Club
67073  673BD4D0  ...                                           Run Away
67130  A39D073A  ...                             Straight From The Gate
67153  C5B585B6  ...                              Les promesses du vent
67167  E9C3DD57  ...                                Marukotojinanoteema
67198  5EDBB494  ...                                         Paper Moon
67206  23840CC7  ...                                      Self Portrait
67218  44D9ED5F  ...                                                Wes
67224  21382F09  ...                                     Yellow Daisies
67226  21382F09  ...                                               Ocre
67246  41BC63DF  ...                                       Berlin Mitte
67251  D6317828  ...                                          Evolution
67272  2023BB0A  ...                                             Whammy
67312  70551018  ...                                        Magic Touch
67358  2DA6FA94  ...                                 Fly Me to the Moon
67383  E4D50896  ...                                      Indian Summer
67386  9464CEB8  ...                                    Peasant Wedding
67436  E1E2EA29  ...                                       Grace of God
67451  DF2B4DF1  ...                                        True Colors
67467  923F4054  ...                                           Barbados
67489  5F825A4E  ...                                 Sudden Inspiration
67498  42B9AC8D  ...                             The last seven minutes
67534  EC51704F  ...                                      Song of India
67540  F300D3EB  ...                                          The Beast
67607  CE921E9C  ...                              The Holly and the Ivy
67622  23D08F4A  ...                                      Urbi Et Orbit
67706  91B6F09B  ...                                    Co ' Long Mule!
67757  BB8802D4  ...                                          Muy Bueno
67768   4F35388  ...                                       Monk's Dream
67774  66961074  ...  Coffee & Poker (feat. Scott Metcalfe: Keys; El...

[2154 rows x 5 columns]
        user_id  ...                                 track
0      BF6EA5AF  ...                                Musica
1      FB1E568E  ...                           Love Planet
2      FB1E568E  ...                           Love Planet
4      82F52E69  ...                Me And My Broken Heart
7      386FE1ED  ...                               Riviera
9      E9E8A0CA  ...                                  Dove
12     2E50EDF9  ...                                 Cludo
20     892E9835  ...                                Sonora
21     46EB28CD  ...                         Hasta Siempre
22     919EFA26  ...                              Patterns
25     13C442BF  ...                            Lightspeed
27     A6D6DBE7  ...               Инструментальная музыка
28     9C97ECE2  ...                         Don't Hurt Me
32     8DA2ADAC  ...                             KICK BOOM
35      D8B3971  ...                         It's So Easy!
38     A6152E0B  ...                                 Sofia
43     4D8D4370  ...                         Il Cigno Nero
46     F1014BD5  ...                         Love's Sorrow
50     1D1186AA  ...                            Дубль один
53     D9111D79  ...                  Разбегается на куски
54     C4C63D22  ...                               A Drive
57     1602CC14  ...                                 Навчи
58     F2EF24F8  ...               Finding Something To Do
60     6C936B97  ...   Bawitdaba (Made Famous by Kid Rock)
61     220A6FF8  ...                 From the End of Light
69     8431D955  ...                         Bootleg Style
71     8AA53E75  ...                       Packet Of Peace
73     61B6E597  ...                               Wrap Em
78     20B8C4FB  ...                    Rakkautta ja rahaa
79     C22BEA45  ...                  I Seek No Other Life
...         ...  ...                                   ...
67879  E0AE9F4F  ...                                  Зима
67881  9F486D92  ...                                Mariah
67883  D563732F  ...                              Малименя
67889  54F9E265  ...        Song of the Barren Orange Tree
67890  2DA6FA94  ...  KeyB 02 Mix Down 04 (von Session 01)
67891  6C22B261  ...                             Ascension
67898  38E06BD9  ...                      Zydepunks Medley
67901  2C14FABD  ...                                  Exil
67904  49A9FB19  ...                         Touch the Sun
67911  DA333564  ...                      Que Me Quedes Tú
67914  A69390D2  ...                   Elenko Mome Malenko
67915  BFCEC5EC  ...                              Gameface
67925  855E8007  ...   5 Little Kittens Jumping on the Bed
67928  B8B73AB6  ...               Dance Of The Bad Angels
67930  36EFE259  ...                  This Is – Aslan 1986
67933  D43E832F  ...                                   XXL
67935  7E444473  ...                                   TCR
67936  D6CFB842  ...                           Making Love
67938  6E35C420  ...                              Insanity
67939  A1C12E5F  ...                     Sunset of Cruelty
67940  975E012C  ...                       Off to Get Lost
67941  20C34C58  ...                           Easy And Me
67942  C4BA00AE  ...                        Human Hardware
67943  A6BA0B2F  ...                              Skarabey
67948  C5272FDF  ...                   Who Killed Franklin
67954  6E8E430E  ...                               Emotion
67955  D83CBA77  ...                           Не отступай
67957  18510741  ...                         Chant A Psalm
67958  2E27DF51  ...                         Girls On Fire
67960  26B7058C  ...                             Действуй!

[25696 rows x 5 columns]
        user_id  ...                                 track
3      EF15C7BA  ...                   Loving Every Minute
5      4166D680  ...                                  Home
6       F4F5677  ...                                   NaN
8      A5E0D927  ...  The Name of This Next Song Is Called
10     D3DD8D00  ...                           Morning Dew
11     596A4517  ...                               Bye Bye
13     79D2876C  ...                    Räuber und Gendarm
14      5A3095E  ...                                   NaN
15     96DA13A1  ...         Пойти и не вернуться. Глава 1
18     285648EF  ...                               No Love
19     34811AC9  ...                             Feel Good
24     94E73621  ...                   My God Is a Bad Cop
26     C4AF055B  ...                                   NaN
31     90004D45  ...                              You Lose
33     65608E7C  ...                 Don't Dream It's Over
34     A7BA3C55  ...                            La Tortura
36     C087E463  ...                      Future Baby Mama
39     29BBA33D  ...                             Never You
40     2FBD8201  ...                                   NaN
41     2F4F0630  ...                           Cool Breeze
45     4AD7F9E2  ...                     Ride Into the Sun
47     B39466EE  ...                                   NaN
49     C484328A  ...         All My Demons Have Distortion
51     58D5A9C7  ...                         Born to Party
55     D52D00EA  ...                        Люби меня люби
63     BBFBFE04  ...                        Me Is Not Pain
64     14313BCE  ...                         The Biker Bar
66     89F8A4B6  ...                             Neurofunk
68     52626181  ...                       Promesa de Amor
70     EA665694  ...                Солнце похожее на тебя
...         ...  ...                                   ...
67878   CE66E39  ...                       Yazmaları Oyalı
67880  65683DF2  ...                             Reach Out
67885  AFD6F763  ...                             Anksiyete
67886  1404DE7C  ...                Football's Coming Home
67887  E04AE357  ...                                   Hey
67888  142AA8A9  ...                               Trooper
67894  EF0F9619  ...                          Interstellar
67896  725E1CB6  ...                           Empty Skies
67897   F5D8F58  ...                 When Love Breaks Down
67899  9D10E051  ...                Sí (Put Your Hands Up)
67900  B7668C53  ...                              Millions
67905  59CB8B4E  ...                      Have I the Right
67906  A9F3B6E8  ...                        Unlisted Blues
67907  52888D22  ...              Preservation of the Wild
67908  A3FAEBA4  ...                         It Is a Crime
67912   64B3917  ...        Thank U 4 Letting Me Be Myself
67916  63937962  ...                          Advenimiento
67917  33780514  ...                           Kiss My Abs
67918  22C29A23  ...                                   NaN
67923  CA3E044B  ...                               My Body
67927   2B61950  ...                           Up and Down
67929  DF5B186D  ...                             China.Bus
67932  2BC0E47A  ...                                   NaN
67946  6C3149FB  ...                          Coultergeist
67949  BCDE19B0  ...                           Made My Day
67950   25A29C7  ...                                Mumbai
67951  A6E13637  ...                                Nearby
67953  A06381D8  ...                          My Old Shoes
67956  816FBC10  ...                              Go Go Go
67962  FE8684F6  ...                                   NaN

[28950 rows x 5 columns]
Para aplicar varias condiciones de filtrado empieza por aplicar la primera condición y guardar el resultado. Entonces, llama a la indexación lógica con la segunda condición:
Código
PYTHON
1
import pandas as pd
2
​
3
df = pd.read_csv('/datasets/music_log.csv')
4
​
5
# seleccionando las filas en las que el género es el jazz y el total de reproducciones está entre 80 y 130
6
df = df[df['total play'] >= 80]
7
df = df[df['total play'] <= 130]
8
df = df[df['genre'] == 'jazz']
9
​
10
print(df)
Resultado
        user_id  ...                                              track
406    7F77F050  ...                                                NaN
1491   E7FD0BD8  ...                                                NaN
2107   C239B913  ...                        Mirabile Mysterium / Births
2368   7EF4E404  ...                                    The 408 Special
6196   70F74E63  ...                                        Still Happy
8341   78B066AB  ...                                          Soft Jazz
8958   A1CDE834  ...                                            Rosetta
10830  22D4E298  ...                                         Comes Love
11301  61628DD8  ...                                 The Riviera Affair
11864  99A76674  ...                                      Ban Ban Quere
12075  6856B582  ...  1936 Ussr Anthem's Stalin Life Has Become Bett...
12133  E77BC5EE  ...                                           Sign Off
12606  C5917288  ...                                      Dis Ol' Train
16035  3B6D91C1  ...                                   Yacht Club Swing
18203  68FBC438  ...                                       Pianist Whim
18261  270BE909  ...                                      Dance for Joy
19944  FFC5FEA7  ...                                              Ergon
21292  D3DD8D00  ...                                          Madeleine
22534  866A9FF2  ...                                         Jennie Lee
26206  16DFAEAD  ...                             It's a Wonderful World
26628  ED289153  ...                                       Hard to Cope
27116  51D70E45  ...                                Always By Your Side
27174   A7CE8AB  ...                                              Paris
28494  5D9AAD37  ...                                           Con Alma
29184  ABD19109  ...                                          Road Walk
30080  C954E22B  ...                    Etudes Op. 10: No. 3 in E Major
31239  1637E28B  ...                                    A Smo-o-oth One
32104  F879B293  ...                                           Mindjoke
32307  C0C19FA8  ...                               Why Must We Be Alone
32913   55E798A  ...                                 West Side Serenade
...         ...  ...                                                ...
38277  48729516  ...                          One for All - All for One
38333  C451C499  ...                                            Mr Syms
41027  901D9D2A  ...                                       Slow Walkin’
41411   C67E290  ...                                                NaN
42449  7EB5C3DD  ...                                      Pent-Up Chaos
46144  14BFF213  ...                          Open Up Them Pearly Gates
46741  4C450805  ...                                      Unforgettable
47119  2747B350  ...                                          Cantilena
47767   E3B1528  ...                                      Shout for Joy
49231   3420F04  ...                                             Europa
49883  AD57A3BA  ...        Four Little Heals (The Clickity Clack Song)
50986  A8EE7436  ...                                          Rhode Man
51806  866A9FF2  ...                                         Jennie Lee
51840  A706AD85  ...                                          Love Trap
53821  B20BF310  ...                                        Let's Do It
54193  35567C28  ...                                           Neo Jazz
54852  3E7BEA31  ...                                        Giant Steps
54904  DD015462  ...                                 Caribbean Solitude
55067   AB6A6EB  ...                         The Windmills Of Your Mind
56642  A12AEA06  ...                                           Perfidia
58136  6A4F2C63  ...                                      The Bread Man
58934   E54DF2E  ...                                        Алло Долли!
59794  397BB2BB  ...                                   Rhapsody in Blue
59924  7954439E  ...                Apasionada (feat. Michael Sembello)
60341  B5DECB56  ...                                        In The Mood
60591  DE8CC264  ...                                            Caravan
61940  EDD05F4F  ...                                         Temptation
62682  AEC6E89B  ...                                     Something Else
66986  A4D6D142  ...                                          The Noise
67489  5F825A4E  ...                                 Sudden Inspiration

[68 rows x 5 columns]
Así es como funciona la aplicación consecutiva de la indexación lógica. En los próximos capítulos, mostraremos cómo combinar dichas expresiones en una línea de código.


"""


"""
////////////////////////////////////////////////////////////////////////////////////////
******************************************************************************************
//////////////////////////////////////////////////////////////////////////////////////////////
"""




"""
El objeto Series
En la lección anterior, comentamos que no se puede acceder a celdas y filas separadas con notación abreviada. Para saber el porqué, tenemos que analizar más detenidamente cómo se estructuran las tablas Pandas. Esto nos dará a conocer una nueva estructura de datos: el objeto Series.
Si recuperas varias columnas o filas de una tabla obtendrás una nueva:
import pandas as pd

df = pd.read_csv('/datasets/music_log.csv')
print(type(df))

part_df = df[['genre', 'Artist']]
print(type(part_df)) 
<class 'pandas.core.frame.DataFrame'>
<class 'pandas.core.frame.DataFrame'> 
Pero si recuperas solo una columna obtendrás un objeto de otro tipo: un objeto Series.
part_df = df['Artist']
print(type(part_df)) 
<class 'pandas.core.series.Series'> 
Una Serie es un bloque que compone una tabla. Así es como se estructuran:
DataFrames y Series
image
Cada columna es un objeto Series. Podemos recuperar un objeto Serie separado de un DataFrame y construir uno nuevo a partir de él.
A diferencia de los DataFrame, una Serie es una estructura unidimensional. Mientras que a los datos de un DataFrame se accede a través de dos coordenadas (nombre de la columna e índice), un Serie solo requiere el índice.
No obstante, una Serie también tiene un nombre. Cuando se construye un DataFrame a partir de diferentes columnas el nombre de un objeto Series se convierte en el nombre de la columna. Cuando se trabaja con una Serie individual generalmente no se necesita el nombre.
Además del nombre, una Serie tiene longitud, es decir, el número total de celdas.
Indexación en una Serie
La Indexación en una Serie funciona igual que en un DataFrame. La principal diferencia es la ausencia del segundo eje:
import pandas as pd
df = pd.read_csv('/datasets/music_log.csv')

# obtener un objeto Series desde el DataFrame
artist = df['Artist']

# Obtener una celda de un Serie con una sola coordenada
print(artist[0]) 
Marina Rei 
En un DataFrame, una solicitud de una celda similar daría lugar a un error:
# Utilizando notación abreviada para obtener una fila
# de una tabla por una sola coordenada
print(df[0]) 
KeyError: 0 
Si utilizas la notación abreviada, no puedes acceder a una celda individual del DataFrame sin indicar el nombre de la columna. Sin embargo, en una Serie solo hay una columna por lo que esto no es un problema.
Ya has visto una organización de datos similar cuando estudiaste estructuras complejas como listas de diccionarios y diccionarios de listas. Allí también había que acceder a los datos por dos coordenadas:
En una lista de diccionarios, se indica primero el índice de la lista y luego la clave del diccionario
En un diccionario de listas ocurre lo contrario: primero viene la clave, luego el índice
Un DataFrame en Pandas puede ser comparado con un diccionario de listas. Para recuperar datos de una tabla, hay que indicar el nombre de la columna y el índice. En este caso, la Serie actuará como una lista y el DataFrame completo como un diccionario de listas.
La indexación de una Serie es similar a la indexación de un DataFrame. Además, existe una notación completa y otra abreviada:
Type	Full notation	Shortened notation
Un elemento	total_play.loc[7]	total_play[7]
Múltiples elementos	total_play.loc[[5, 7, 10]]	total_play[[5, 7, 10]]
Múltiples elementos consecutivos (un slice)	total_play.loc[5:10] incluyendo 10	total_play[5:10] sin incluir 10
Todos los elementos a partir del elemento dado	total_play.loc[1:]	total_play[1:]
Todos los elementos hasta el elemento dado	total_play.loc[:3] incluyendo 3	total_play[:3] sin incluir 3
La Indexación lógica también funciona para una Serie. Parece mucho más sencillo que el equivalente de un DataFrame. En una Serie, una condición lógica es suficiente. No es necesario indicar la columna de la que proceden los datos:
image
Cuando solo se necesita analizar una columna de una tabla puede ser una buena idea almacenar la columna en una variable separada; de esta manera, no será necesario indicar el nombre de la columna una y otra vez. Prueba algunos ejercicios para que puedas ver cómo funciona por ti mismo.

"""
