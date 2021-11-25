<template>
    <div class="row mt-5">
        <div class="card bg-dark col-md-12">
            <div class="card-header">UwUify</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="text" class="form-label">Je text</label>
                    <textarea class="form-control form-control-lg" id="uwuin" rows="3" placeholder="UwU in" v-model="textToUwuIfy"></textarea>
                </div>
                <label for="text" class="form-label">Je UwU</label>
                <div class="input-group mb-3">
                    <textarea class="form-control form-control-lg" id="uwuout" rows="3"
                        placeholder="UwU out" v-model="textUwuFied"></textarea>
                    <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#uwuModel"><i
                            class="far fa-copy"></i></button>
                </div>
                <!-- <button class="btn btn-primary">UwUify!</button> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            textToUwuIfy: '',
        };
    },

    computed: {
        textUwuFied: function () {
            let text = this.textToUwuIfy.replace(/r|l/g, 'w')
                .replace(/L|R/g, 'W')
                .replace(/Na/g, 'Nya')
                .replace(/na/g, 'nya')
                .replace(/et/g, 'ewt')
                .replace(/Et/g, 'Ewt')
                .replace(/ne/g, 'nye')
                .replace(/Ne/g, 'Nye')
                .replace(/nu/g, 'nyu')
                .replace(/Nu/g, 'Nyu')
                .replace(/ni/g, 'nyi')
                .replace(/NI/g, 'Nyi')
                .replace(/haha/g, 'hihi')
                .replace(/Haha/g, 'Hihi ^-^')
                .replace(/\!/g, '!!1!')
                .replace(/\?/g, '?!')
                .replace(/Ik /g, 'I-Ik UwU ')
                .replace(/ik /g, 'i-ik ')
                .replace(/ ik /g, ' i-ik ')
                .replace(/ Ik /g, ' I-Ik ')
                .replace(/uh /g, 'u-uh ')
                .replace(/ uh /g, ' u-uh ');

                // if (Math.floor(Math.random() * 11) === 2) {
                //     console.log('yoooo triggerd');
                //     // text.substring(0,4)+'x'+text.substring(5)
                //     let place = place = Math.floor(Math.random() * text.length)
                //     text = this.replaceAt(text, place, text.charAt(place) + '-' + text.charAt(place))
                // }

            return text;

        }
    },

    methods: {
        replaceAt(str,index,chr) {
            if(index > str.length-1) return str;
            return str.substring(0,index) + chr + str.substring(index+1);
        },
    },


};
</script>
