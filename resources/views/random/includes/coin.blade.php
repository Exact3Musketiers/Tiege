<div class="jumbotron mx-auto" style="display: grid; height: 200px">
    <button class="btn btn-primary" id="flipButton" onclick="flipCoin()">Click for heads/tails</button>
    <div id="hand"></div>
    <div id="coin"></div>
    <div id="coinResult" class="display-3 mx-auto"></div>
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
            coin.innerHTML = '<i class="fas fa-ring fa-spin w-50 display-3"></i>';

            setTimeout(() => {
                if (Math.floor(Math.random() * (1 - 0 + 1)) + 0 == 1)
                    coinResult.innerHTML = 'Het is: Head';
                else
                    coinResult.innerHTML = 'Het is: Tails';
                coin.innerHTML = '';
                hand.innerHTML = '';
                flipButton.disabled = false;
            }, 1000);
        }, 1000);

    }
</script>


<style>
    #hand i {
        transform: scale(-1, 1);
    }

    #coin {
        color: gold;
    }

    .animateHand {
        width: 10px;
        animation: myfirst 2s;
        animation-direction: alternate;
        animation-iteration-count: infinite;
    }

    @keyframes myfirst {
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
