<script>
import { library } from '@fortawesome/fontawesome-svg-core';
import { faAngleDown, faAngleUp } from '@fortawesome/free-solid-svg-icons';

library.add(faAngleDown, faAngleUp);


export default {
    data() {
        return {
            open: false,
            contentStyle: {
                // maxHeight: 0,
                overflow: 'hidden',
                transition: 'max-height 0.2s ease-out'
            }
        }
    },
    methods: {
        toggleContent() {
            if (this.contentStyle.maxHeight) {
                this.contentStyle.maxHeight = 0;
                this.open = true;
            } else {
                this.contentStyle.maxHeight = this.$el.lastChild.firstChild.scrollHeight + "px";
                this.open = false;
            }
        }
    }
}
</script>
