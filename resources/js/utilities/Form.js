import Errors from './Errors';

class Form {

    constructor(data) {

        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();

        this.isLoading = false;

    }

    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }

    data() {

        let data = {};

        for (let property in this.originalData) {

            data[property] = this[property];

        }

        return data;

    }

    post(url) {
        return this.submit('post', url);
    }

    submit(requestType, url) {

        this.isLoading = true;

        return new Promise((resolve, reject) => {

            axios[requestType](url, this.data())

            .then(response => {
                this.onSuccess(response.data);
                resolve(response.data);
            })
            .catch(error => {
                this.onFail(error.response.data);
                reject(error.response.data);
            });

        });

    }

    onSuccess(data) {

        this.isLoading = false;

        this.reset();

    }

    onFail(response) {

        this.isLoading = false;

        this.errors.record(response.errors);

    }
}

export default Form;