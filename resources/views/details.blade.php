 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Vol</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            padding: 40px;
        }
        
        .container{ 
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        section.details {
            flex: 1;
            min-width: 300px;
            margin-right: 20px;
        }
        
        section.details h1 {
            color: #007bff;
            margin-bottom: 20px;
        }

        section.details p {
            font-size: 16px;
    
                   margin-bottom: 10px;
        }

        section.image {
            flex: 1;
            min-width: 300px;
        }

        section.image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            border: 3px solid #007bff;
        }


        h1 {
            color: #007bff;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            margin: 10px 0px 0px 20px;
            padding: 10px 20px;
            background-color: rgb(31, 31, 56);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        #img3 {
            width: 275px;
            height: auto;
            border: 5px solid black;
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="content">
           <section class="details">
               <h1>Détails du Vol {{$vol->id }}</h1>
               <p><strong>Ville de départ :</strong> {{ $vol->depart}} </p>
               <p><strong>Ville d’arrivée :</strong> {{$vol->destination}}</p>
               <p><strong>Pays de départ :</strong> {{ $vol->pays_depart }}</p>
               <p><strong>Pays d’arrivée :</strong>{{$vol->pays_arrivee }}</p>
               <p><strong>Date de départ :</strong> {{ $vol->date_depart}} </p>
               <p><strong>Heure de départ :</strong>{{$vol->heure_depart }}</p>
               <p><strong>Heure d’arrivée :</strong> {{ $vol->heure_arrivee }}</p>
               <p><strong>Nombre de places disponibles :</strong>{{$vol->places_disponibles }}</p>
               <p><strong>Compagnie aérienne :</strong> {{ $vol->compagnie}} ?? 'Non spécifiée' </p>
            </section>
            <section classe="image">
             <img src="{{ asset('image/volimage.jpeg') }}" alt="Avion en vol" id="img3">
             </section>
        </div>    
        <div>
           <a href="{{ route('reserver', ['vol_id' =>$vol->id]) }}" class="btn"> Réserver ce vol</a>
           <a href="{{ route('vols_disponible', ['vol_id' =>$vol->id]) }}" class="btn"> Retour</a>
        </div>
   </div>
</body>
</html>

