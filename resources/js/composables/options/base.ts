import {
    AuthorType,
    CategoryType,
    OptionType,
    TagType,
    UserType,
} from "@/types";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

export const breakpoints = ["sm", "md", "lg", "xl"];
export const breakpointTabs = breakpoints.map((b) => ({
    name: b,
    title: b,
}));

export const sides = ["top", "start", "end", "bottom"];

export const sideOptions = sides.map((s) => ({
    label: s.charAt(0).toUpperCase() + s.slice(1),
    name: s,
    value: s.charAt(0),
}));

export const useThemeOptions = (): OptionType[] => {
    return [
        {
            label: "none",
            value: null,
        },
        {
            label: "light",
            value: "light",
        },
        {
            label: "dark",
            value: "dark",
        },
    ];
};
export const useSortOptions = () => {
    const page = usePage<{ props: { sortOptions: OptionType[] } }>();
    return (page.props.sortOptions as OptionType[]) ?? [];
};
export const useTags = () => {
    const page = usePage<{ props: { tags: TagType[] } }>();
    return (page.props.tags as TagType[]) ?? [];
};

export const useTagOptions = () => {
    return computed(() =>
        (useTags() as TagType[]).map((tag: TagType) => ({
            label: `${tag.name}`,
            value: `${tag.id}`,
        })),
    );
};
export const useCategories = () => {
    const page = usePage<{ props: { categories: CategoryType[] } }>();
    return (page.props.categories as CategoryType[]) ?? [];
};

export const useCategoryOptions = () => {
    return computed(() =>
        (useCategories() as CategoryType[]).map((cat: CategoryType) => ({
            label: `${cat.name}`,
            value: `${cat.id}`,
        })),
    );
};

export const useAuthors = () => {
    const page = usePage<{ props: { authors: AuthorType[] } }>();
    return (page.props.authors as AuthorType[]) ?? [];
};

export const useAuthorOptions = () => {
    return computed(() =>
        (useAuthors() as AuthorType[]).map((author: AuthorType) => ({
            label: `${author.name}`,
            value: `${author.id}`,
        })),
    );
};

export const useUsers = () => {
    const page = usePage<{ props: { users: UserType[] } }>();
    return (page.props.users as UserType[]) ?? [];
};

export const useUserOptions = () => {
    return computed(() =>
        (useUsers() as UserType[]).map((user: UserType) => ({
            label: `${user.display_name}`,
            value: `${user.id}`,
        })),
    );
};
