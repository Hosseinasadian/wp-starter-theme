/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import {__} from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {useBlockProps,InspectorControls} from '@wordpress/block-editor';
import { PanelBody,ColorPalette,RangeControl } from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import { useSelect } from '@wordpress/data';



/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
	const { attributes:{backgroundColor,fontSize, itemCount}, setAttributes } = props;

	const posts = useSelect((select) => {
		return select('core').getEntityRecords('postType', 'post', { per_page: itemCount });
	}, [itemCount]);

	const blockProps = useBlockProps({
		style: { backgroundColor, fontSize: `${fontSize}px` }
	});

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={__('Settings', 'todo-list')} initialOpen={true}>
					<p>{__('Background Color', 'todo-list')}</p>
					<ColorPalette
						value={backgroundColor}
						onChange={(newColor) => setAttributes({backgroundColor: newColor})}
					/>
					<RangeControl
						label={__('Font Size', 'todo-list')}
						value={fontSize}
						onChange={(newSize) => setAttributes({ fontSize: newSize })}
						min={10}
						max={50}
					/>
					<RangeControl
						label={__('Item Count', 'todo-list')}
						value={itemCount}
						onChange={(newCount) => setAttributes({ itemCount: newCount })}
						min={1}
						max={20}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...blockProps}>
				{posts && posts.length > 0 ? (
					posts.map((post) => (
						<div key={post.id}>
							<h4>{post.title.rendered}</h4>
						</div>
					))
				) : (
					<div>{__('No posts found', 'todo-list')}</div>
				)}
			</div>
		</Fragment>
	);
}
