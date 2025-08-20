import { UserType } from "@/types/user";
import { usePage } from "@inertiajs/vue3"
import { computed } from "vue";

export const useUsers = () => {
    const page = usePage<{ props: { users: UserType[] } }>()
    return (page.props.users as UserType[]) ?? [];
}

export const useUserOptions = () => {
    const users = useUsers();
    return computed(() =>
        (users as UserType[]).map((user: UserType) => ({
            label: `${user.display_name}`,
            value: `${user.id}`,
        }))
    );
}
