
<div class="row mt-3" id="rngPage">
    <div class="card bg-dark col-md-12">
        <div class="card-body text-center">
            <div class="input-group mb-3">
                <span class="input-group-text bg-primary border-primary"">#1</span>
                <input type="number" id="numberInput1" class="form-control" placeholder="Number 1" aria-label="Number 1">
                <span class="input-group-text bg-primary border-primary">#2</span>
                <input type="number" id="numberInput2" class="form-control" placeholder="Number 2" aria-label="Number 2">
            </div>
            <button id="rngButton" class="btn btn-primary mb-3 w-100" onclick="rng();">Pak een lekker random getalletje</button>
            <div class="rng-arena p-3 pt-2 mx-auto d-flex flex-column justify-content-center">
                <h1 id="rngText" class="h4 m-0"></h1>
                <h1 id="drum" class="m-0">Random nummer</h1>
                <h1 id="numberText" class="m-0"></h1>
            </div>
        </div>
    </div>
</div>

<script>
    function rng() {
        let drum = document.getElementById('drum');
        let rngText = document.getElementById('rngText');
        let rngButton = document.getElementById('rngButton');
        let numberText = document.getElementById('numberText');
        let input1 = document.getElementById('numberInput1');
        let input2 = document.getElementById('numberInput2');

        if (input1.value == '' || input2.value == '') {
            alert('Niet vergeten een getal in te vullen')
            return;
        }
        if (parseInt(input1.value) >= parseInt(input2.value)) {
            alert('Het eerste getal kan niet hoger zijn dan het laatste getal')
            return;
        }

        numberText.innerHTML = '';
        rngText.innerHTML = 'En je getalletje is......';
        drum.innerHTML = '<i class="fas fa-drum animateDrum"></i>';
        rngButton.disabled = true;

        setTimeout(() => {
            drum.innerHTML = '';

            let random = Math.floor(Math.random() * (parseInt(input2.value) - parseInt(input1.value) + 1)) + parseInt(input1.value);
            numberText.innerHTML = random;

            rngButton.disabled = false;
        }, 2000);
    }
</script>
