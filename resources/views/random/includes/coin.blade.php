<div id="coinPage" class="jumbotron mx-auto">
    <button class="btn btn-primary" id="flipButton" onclick="flipCoin()">Click for heads/tails</button>
    <div id="hand"></div>
    <div id="coin"></div>
    <div id="coinResult" class="display-4 mx-auto"></div>
</div>


<script>
    function flipCoin() {
        let coinResult = document.getElementById('coinResult');
        let hand = document.getElementById('hand');
        let coin = document.getElementById('coin');
        let flipButton = document.getElementById('flipButton');

        coinResult.innerHTML = '';
        hand.classList.add('animateHand');
        hand.innerHTML = '<i class="fas fa-hand-lizard display-3"></i>';
        flipButton.disabled = true;

        setTimeout(() => {
            hand.classList.remove('animateHand');
            coin.innerHTML = '<i class="fas fa-coin fa-spin w-50 display-3"></i>';

            setTimeout(() => {
                if (Math.floor(Math.random() * (1 - 0 + 1)) + 0 == 1)
                    coinResult.innerHTML = '<img src="{{asset("images/heads.png")}}"><p class="text-center">Heads</p>';
                else
                    coinResult.innerHTML = '<img src="{{asset("images/tails.png")}}"><p class="text-center">Tails</p>';
                coin.innerHTML = '';
                hand.innerHTML = '';
                flipButton.disabled = false;
            }, 1000);
        }, 1000);

    }
</script>


<style>
    #coinPage{
        display: grid;
        height: 320px;
    }
    #coinPage .btn{
        height: 40px;
    }
    #hand i {
        transform: scale(-1, 1);
    }

    #coin {
        color: gold;
    }

    .animateHand {
        width: 10px;
        animation: rotateHand 2s;
        animation-direction: alternate;
        animation-iteration-count: infinite;
    }

    @keyframes rotateHand {
        0% {
            margin-top: 0px;
            transform: rotate(0deg)
        }
        25% {
            margin-top: 25px;
            transform: rotate(30deg)
        }
        75% {
            margin-top: 0px;
            transform: rotate(-20deg)
        }
        100% {
            margin-top: -50px;
            transform: rotate(-50deg)
        }
    }
</style>
