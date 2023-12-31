/* jshint esversion: 6 */
import PropTypes from 'prop-types';
import classnames from 'classnames';
import ResponsiveControl from '../common/responsive.js';
import Icons from '../common/icons.js';

const { __ } = wp.i18n;

const { ButtonGroup, Dashicon, Tooltip, Button } = wp.components;

const { Component, Fragment } = wp.element;
class ItemComponent extends Component {
	constructor() {
		super( ...arguments );
		this.choices = ( thebaseCustomizerControlsData && thebaseCustomizerControlsData.choices && thebaseCustomizerControlsData.choices[ this.props.controlParams.group ] ? thebaseCustomizerControlsData.choices[ this.props.controlParams.group ] : [] );
	}
	render() {
		return (
			<div className="thebase-builder-item" data-id={ this.props.item } data-section={ undefined !== this.choices[ this.props.item ] && undefined !== this.choices[ this.props.item ].section ? this.choices[ this.props.item ].section : '' } key={ this.props.item }>
				<span
					className="thebase-builder-item-icon thebase-move-icon"
				>
					{ Icons['drag'] }
				</span>
				<span
					className="thebase-builder-item-text"
				>
					{ ( undefined !== this.choices[ this.props.item ] && undefined !== this.choices[ this.props.item ].name ? this.choices[ this.props.item ].name : '' ) }
				</span>
				<Button
					className="thebase-builder-item-focus-icon thebase-builder-item-icon"
					aria-label={ __( 'Setting settings for', 'basetheme' ) + ' ' + ( undefined !== this.choices[ this.props.item ] && undefined !== this.choices[ this.props.item ].name ? this.choices[ this.props.item ].name : '' ) }
					onClick={ () => {
						this.props.focusItem( undefined !== this.choices[ this.props.item ] && undefined !== this.choices[ this.props.item ].section ? this.choices[ this.props.item ].section : '' );
					} }
				>
					<Dashicon icon="admin-generic"/>
				</Button>
				{ thebaseCustomizerControlsData.blockWidgets && this.props.item.includes('widget') && 'toggle-widget' !== this.props.item && (
					<Button
						className="thebase-builder-item-focus-icon thebase-builder-item-icon"
						aria-label={ __( 'Setting settings for', 'basetheme' ) + ' ' + ( undefined !== this.choices[ this.props.item ] && undefined !== this.choices[ this.props.item ].name ? this.choices[ this.props.item ].name : '' ) }
						onClick={ () => {
							this.props.focusItem( undefined !== this.choices[ this.props.item ] && undefined !== this.choices[ this.props.item ].section ? 'thebase_customizer_' + this.choices[ this.props.item ].section : '' );
						} }
					>
						<Dashicon icon="admin-settings"/>
					</Button>
				) }
				{ thebaseCustomizerControlsData.blockWidgets && 'toggle-widget' === this.props.item && (
					<Button
						className="thebase-builder-item-focus-icon thebase-builder-item-icon"
						aria-label={ __( 'Setting settings for', 'basetheme' ) + ' ' + ( undefined !== this.choices[ this.props.item ] && undefined !== this.choices[ this.props.item ].name ? this.choices[ this.props.item ].name : '' ) }
						onClick={ () => {
							this.props.focusItem( 'thebase_customizer_sidebar-widgets-header2' );
						} }
					>
						<Dashicon icon="admin-settings"/>
					</Button>
				) }
				<Button
					className="thebase-builder-item-icon"
					aria-label={ __( 'Remove', 'basetheme' ) + ' ' + ( undefined !== this.choices[ this.props.item ] && undefined !== this.choices[ this.props.item ].name ? this.choices[ this.props.item ].name : '' ) }
					onClick={ () => {
						this.props.removeItem( this.props.item );
					} }
				>
					<Dashicon icon="no-alt"/>
				</Button>
			</div>
		);
	}
}
export default ItemComponent;
