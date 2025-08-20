export interface BlockFeatures {
    typography: boolean;
    bgColor: boolean;
    bgImage: boolean;
    margin: boolean;
    padding: boolean;
    border: boolean;
    shadow: boolean;
    htmlAnchor: boolean;
    className: boolean;
    style: boolean;
}

export interface BlockType {
    id: string;
    type: string;
    icon?: string;
    label?: string;
    children?: BlockType[];
    inner?: string | string[];
    features: string[];
    attributes: Record<string, any>;
    [key: string]: any;
}
/* export interface BaseBlock{
    id: string
    type: string
    label: string
    icon?: string
    className?: string
    defaults: Record<string, any>
}

export interface PostsGridType extends BaseBlock{
    title?: string
    show_title: true
    categories?: number[]
    tags?: number[]
    users?: number
    limit?: number
    sort?: string
}
export interface QuotesGridType extends BaseBlock{
    title?: string
    show_title: true
    categories?: number[]
    tags?: number[]
    users?: number
    authors?: number
    limit?: number
    sort?: string
}
export interface BooksGridType extends BaseBlock{
    title?: string
    show_title: true
    categories?: number[]
    tags?: number[]
    users?: number
    authors?: number
    limit?: number
    sort?: string
}
export interface CategoriesGridType extends BaseBlock{
    title?: string
    show_title: true
    users?: number
    limit?: number
    sort?: string
}
export interface AuthorsGridType extends BaseBlock{
    title?: string
    show_title: true
    users?: number
    limit?: number
    sort?: string
}
export interface TextBlockType extends BaseBlock{
    content?: string
}

export interface ButtonType extends BaseBlock{
    label: string
    icon?: string
    url?: string
    target?: string
    color?: string
    outline: false
    gradient: false
    pill: false
    size: string
}
export interface HeroBlockType extends BaseBlock{
    fullscreen?: boolean
    theme?: string
    title?: string
    subtitle?: string
    text?: string
    color?: string
    bgcolor?: string
    image?: string
    children?: ButtonType[]
}
 */
