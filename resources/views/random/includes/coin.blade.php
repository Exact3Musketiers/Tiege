<div id="coinPage" class="jumbotron mx-auto d-grid">
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
