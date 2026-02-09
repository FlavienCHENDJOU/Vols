<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des vols</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .cl1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-vol {
            flex: 1;
            padding-right: 20px;
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

        .btn:hover {
            background-color: #1d1d3c;
        }

        #img3 {
            width: 175px;
            height: auto;
            border: 5px solid black;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <h1>Liste des vols disponibles</h1>
    <ul>
        @foreach ($vols as $vol)
            <li>
                <div class="cl1">
                    <section class="info-vol">
                        {{ $loop->iteration}}  - Vol de <strong>{{ $vol->depart }}</strong> à <strong>{{ $vol->destination }} </strong>,
                        prévu pour le <em>{{$vol->date_depart }}</em> à <em>{{ $vol->heure_depart }}</em>.
                        <div>"
                            <a href="{{ route('reserver',['vol_id' => $vol->id] ) }}" class="btn">Réserver</a>
                            <a href=" {{ route('details', ['id' =>$vol->id]) }}" class="btn">voir les détails</a>
                            
                        </div>
                    </section>

                    <section>
                        <img src="{{ asset('img/volimage.jpeg') }}" alt="Avion en vol" id="img3">
                    </section>
                </div>
            </li>
        @endforeach
    </ul>
</body>
</html>



