/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
/**
 * @module plugins/backspace
 */
import type { IJodit } from "../../../types/index";
/**
 * For the first item in a list on backspace, try to move his content in new P
 *
 * @example
 * ```html
 * <ul><li>|first</li><li>second</li></ul>
 * ```
 * Result
 * ```html
 * <p>|first</p><ul><li>second</li></ul>
 * ```
 *
 * @private
 */
export declare function checkUnwrapFirstListItem(jodit: IJodit, fakeNode: Node, backspace: boolean): boolean;
