/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
/**
 * @module traits
 */
import type { IComponent, IContainer, IElms, Nullable } from "../../types/index";
export declare abstract class Elms implements IElms {
    /**
     * Return element with BEM class name
     */
    getElm<T extends IComponent & IContainer & IElms>(this: T, elementName: string): Nullable<HTMLElement>;
    /**
     * Return elements with BEM class name
     */
    getElms<T extends IComponent & IContainer & IElms>(this: T, elementName: string): HTMLElement[];
}
