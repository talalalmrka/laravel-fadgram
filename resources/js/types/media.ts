// helper for generated conversions like { sm: true, md: true, lg: true }
export type GeneratedConversions = {
    [conversion: string]: boolean | undefined;
    sm?: boolean;
    md?: boolean;
    lg?: boolean;
};

// flexible shape for responsive images (server formats vary)
export type ResponsiveImage = Record<string, unknown>;

// main image object interface
export interface MediaType {
    id: number;
    model_type: string;
    model_id: number;
    uuid: string;
    collection_name: string;
    name: string;
    file_name: string;
    mime_type: string;
    disk: string;
    conversions_disk: string;
    size: number;
    manipulations: string[]; // often an array of strings
    custom_properties: Record<string, unknown>; // arbitrary object
    generated_conversions: GeneratedConversions;
    responsive_images: ResponsiveImage[]; // or [] / array of objects
    order_column: number;
    created_at: string; // ISO timestamp, e.g. "2025-08-11T18:08:14.000000Z"
    updated_at: string;
    original_url: string;
    preview_url: string; // may be empty string or url
    conversions?: Record<string, string>;
    ext: string;
    size_human: string;
}
