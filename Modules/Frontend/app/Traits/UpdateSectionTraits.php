<?php

namespace Modules\Frontend\app\Traits;

trait UpdateSectionTraits {
    /**
     * Updates the specified text and image fields in the given content object.
     *
     * This method updates the properties of a content object based on the
     * values provided in the request. It handles both text and image fields
     * separately, allowing for flexible updates while ensuring that the
     * content remains consistent.
     *
     * @param mixed $content The content object to be updated.
     * @param \Illuminate\Http\Request $request The request object containing the new values.
     * @param array $fields An array of strings representing the names of text fields to update.
     * @param array $images An optional array of strings representing the names of image fields to update.
     *
     * @return mixed The updated content object after applying the changes.
     */
    private function updateSectionContent($content, $request, array $fields, array $images = []) {
        if (is_null($content)) {
            $content = new \stdClass();
        }

        // Update text fields
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $content->$field = $request->$field;
            }
        }

        // Update image fields
        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                $file_name = file_upload($request->$image, 'uploads/custom-images/', $content->$image ?? null);
                $content->$image = $file_name;
            }
        }

        return $content;
    }
}
