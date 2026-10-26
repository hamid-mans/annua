import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = { url: String }

    click() {
        Turbo.visit(this.urlValue)
    }
}
