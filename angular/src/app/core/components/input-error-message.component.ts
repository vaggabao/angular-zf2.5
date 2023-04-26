import { Component, Input, OnChanges } from '@angular/core';

@Component({
    selector: 'input-error-message',
    template: `
        <span class="input-error-message" *ngIf="errorMessage">
            {{errorMessage}}
        </span>
    `
})

export class InputErrorMessageComponent implements OnChanges {
    @Input() public errorDefs: any = {};
    @Input() public inputErrors: any;
    @Input() public manualError: string;
    public errorMessage: string = '';

    ngOnChanges(changes: any): void {
        if (this.manualError) {
            this.errorMessage = this.manualError;
            return;
        }

        let errors: any = changes.inputErrors.currentValue;
        this.errorMessage = '';
        if (errors) {
            Object.keys(errors).some(key => {
                if (errors[key]) {
                    this.errorMessage = this.errorDefs[key];
                    return true;
                }
                return false;
            });
        }
    }
}
