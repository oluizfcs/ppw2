@extends('layouts.app')

@section('titulo', 'Moviestar - Filmes')

@section('conteudo')
    <h1> não foi possivel encontrar este recurso </h1>
    <div class="container d-flex justify-content-center">
        <canvas id="game" width="500px" height="500px"></canvas>
    </div>


<script>
    const canvas = document.getElementById("game");
    const ctx = canvas.getContext("2d");

    let isGameRunning, currentX, currentY, facingDirection, length;

    function freshStart() {
        ctx.reset();
        currentX = 250;
        currentY = 250;
        facingDirection = "ArrowUp";
        length = 1;

        ctx.fillStyle = "#ffac33";
        ctx.fillRect(currentX, currentY, 10, 10);

        isGameRunning = false;
    }

    freshStart();

    document.addEventListener("keydown", (e) => {
        facingDirection = e.key;

        e.preventDefault();

        if (!isGameRunning) {
            startGame();
        }
    });

    const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

    async function startGame() {
        canvas.classList.add("game-active");
        isGameRunning = true;
        while(isGameRunning) {
            switch(facingDirection) {
                case "ArrowLeft":
                    currentX -= 10;
                    break;
                case "ArrowUp":
                    currentY -= 10;
                    break;
                case "ArrowRight":
                    currentX += 10;
                    break;
                case "ArrowDown":
                    currentY += 10;
            }
            
            if (currentX >= canvas.width || currentX <= 0 || currentY >= canvas.height || currentY <= 0) {
                isGameRunning = false;
            }
            

            ctx.fillStyle = "#ffac33";
            ctx.fillRect(currentX, currentY, 10, 10);
            await sleep(100);
        }

        alert("fim de jogo");
        canvas.classList.remove("game-active");
        freshStart();
    }
</script>

<style>
    canvas {
        background-color: #2a2a2a;
        transition: 1s;
    }

    .game-active {
        box-shadow: inset 0 0 20px 2px black;
    }
</style>
@endsection