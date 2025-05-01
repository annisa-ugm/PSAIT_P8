<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PC Games - FreeToGame</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* RETRO THEME */
        body {
            background-color: #f3ecd7;
            font-family: 'Courier New', Courier, monospace;
            color: #333;
        }

        h2 {
            font-weight: bold;
            color: #2c1500;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 1px 1px 0 #fff;
        }

        .game-card {
            background-color: #fffef2;
            border: 2px solid #c9a96e;
            border-radius: 8px;
            margin-bottom: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 3px 3px 0 #a88a5a;
            transition: transform 0.2s;
        }

        .game-card:hover {
            transform: scale(1.02);
        }

        .game-thumbnail {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .game-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .game-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #4b2e00;
        }

        .game-meta {
            font-size: 0.85rem;
            color: #5c4428;
            margin-bottom: 5px;
        }

        .short-description {
            font-size: 0.9rem;
            margin-top: 10px;
            color: #3d2d1c;
            flex-grow: 1;
        }

        .btn-retro {
            background-color: #c9a96e;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
        }

        .btn-retro:hover {
            background-color: #b0884f;
        }

        .card-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .row {
            row-gap: 1.5rem; 
        }

    </style>
</head>
<body>
    <div class="container py-4">
        <h2>🕹️ PC Games</h2>
        <div class="row">

        <?php
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'https://www.freetogame.com/api/games?platform=pc');
        $res = curl_exec($curl);
        curl_close($curl);

        $games = json_decode($res, true);

        if ($games && is_array($games)) {
            foreach ($games as $game) {
                echo '<div class="col-md-4 d-flex">';
                echo '  <div class="card game-card card-wrapper">';
                echo '      <img src="' . $game["thumbnail"] . '" class="game-thumbnail" alt="' . htmlspecialchars($game["title"]) . '">';
                echo '      <div class="card-body game-info">';
                echo '          <div class="game-title">' . htmlspecialchars($game["title"]) . '</div>';
                echo '          <div class="game-meta"><strong>Genre:</strong> ' . $game["genre"] . '</div>';
                echo '          <div class="game-meta"><strong>Release:</strong> ' . $game["release_date"] . '</div>';
                echo '          <div class="game-meta"><strong>Publisher:</strong> ' . $game["publisher"] . '</div>';
                echo '          <div class="short-description">' . htmlspecialchars($game["short_description"]) . '</div>';
                echo '          <a href="' . $game["game_url"] . '" class="btn btn-retro btn-sm mt-2" target="_blank">▶ Play Game</a>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-danger">Failed to fetch data from API.</p>';
        }
        ?>

        </div>
    </div>
</body>
</html>
