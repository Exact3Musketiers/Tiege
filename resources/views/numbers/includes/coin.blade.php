<div id="coinPage">
    <div class="row mt-3">
        <div class="card bg-dark col-md-12">
            <div class="card-body">
                <div class="text-center pb-3">
                    <button class="btn btn-primary w-100" id="flipButton" onclick="flipCoin()">Click for heads/tails</button>
                </div>
                <div class="hot-arena d-flex flex-column justify-content-center">
                    <div id="announcer"><h1 class="text-center fs-large">Kop of Munt</h1></div>
                    <div id="hand"></div>
                    <div id="coin"></div>
                    <div id="coinResult" class="display-4 mx-auto text-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function flipCoin() {
        let coinResult = document.getElementById('coinResult');
        let hand = document.getElementById('hand');
        let coin = document.getElementById('coin');
        let flipButton = document.getElementById('flipButton');

        document.getElementById('announcer').innerHTML = '';

        coinResult.innerHTML = '';
        hand.classList.add('animateHand');
        hand.innerHTML = '<i class="fas fa-hand-lizard display-3"></i>';
        flipButton.disabled = true;

        setTimeout(() => {
            hand.classList.remove('animateHand');
            coin.innerHTML = '<i class="fas fa-coin fa-spin w-50 display-3"></i>';

            setTimeout(() => {
                if (Math.floor(Math.random() * (1 - 0 + 1)) + 0 == 1)
                    coinResult.innerHTML = '<img class="text-center" src="{{asset("images/heads.png")}}"><p class="text-center">Heads</p>';
                else
                    coinResult.innerHTML = '<img class="text-center" src="{{asset("images/tails.png")}}"><p class="text-center">Tails</p>';
                coin.innerHTML = '';
                hand.innerHTML = '';
                flipButton.disabled = false;
            }, 1000);
        }, 1000);

    }
</script>
