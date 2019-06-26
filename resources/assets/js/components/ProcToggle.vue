<script>
export default {
    props:['array_size'],
    data() {
        return {
            vis: []
        }
    },
    mounted() {
        this.vis = new Array(this.array_size).fill(false);
        this.vis[0] = true;
    },
    methods: {
        toggle(i) {
            console.log(i);
            this.vis.fill(false);
            this.vis[i] = true;
        }
    }
}
</script>
