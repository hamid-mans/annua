import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = { type: String };

    connect() {
        if (!this.typeValue) return;

        this.element.dataset.flash = this.typeValue;
        this.typeValue = '';

        this.timeout = setTimeout(() => this.reset(), 4000);
    }

    reset() {
        delete this.element.dataset.flash;
    }

    disconnect() {
        clearTimeout(this.timeout);
    }
}
