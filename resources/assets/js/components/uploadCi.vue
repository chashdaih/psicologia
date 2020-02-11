<template>
    <form :action="url" method="POST" enctype="multipart/form-data" ref="form">
    <input type="hidden" name="_token" :value="csrf">
            <div class="field has-addons has-addons-centered">
                    <div class="file is-info">
                    <label class="file-label" @change="sendForm">
                    <input class="file-input" type="file" name="ci-file" id="ci-file" accept="image/jpeg,image/jpg,image/png,application/pdf,aplication/docx,application/doc">
                    <span class="file-cta">
                            <span class="icon"><fai icon="file-upload" size="1x" /></span>
                    <span class="file-label">
                            Subir CI
                    </span>
                    </span>
                    </label>
                    </div>
            </div>
    </form>
</template>
<script>
export default {
    props:['url'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    methods: {
        sendForm(e) {
            var ext = e.target.value.match(/\.([^\.]+)$/)[1];
            switch (ext) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'pdf':
                case 'docx':
                case 'doc':
            this.$refs.form.submit();
                break;
                default:
                alert('Not allowed');
            }
        }
    }
}
</script>
