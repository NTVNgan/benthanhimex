import TextComponent from './text-component.js';

export const TextControl = wp.customize.TheBaseControl.extend( {
	renderContent: function renderContent() {
		let control = this;
	ReactDOM.render( <TextComponent control={ control } />, control.container[0] );
	}
} );
