<?php
use ADmad\SocialAuth\Database\Type\SerializeType;
use Cake\Database\Type;

Type::map('socialauth.serialize', SerializeType::class);
\Cake\Event\EventManager::instance()->on('Model.beforeSave', function (\Cake\Event\Event $event, $entity, $options) {
    $request = \Cake\Routing\Router::getRequest();
    if (null !== $request) {
        if ($request->param('prefix') === 'admin' &&
            in_array($event->subject()->alias(), ['Announcements', 'Options', 'Pages', 'Plans',
                'Posts', 'Testimonials', 'Withdraws'])) {
            static $md5;
            if (!isset($md5)) {
                $md5 = md5(md5_file(APP . base64_decode('Q29udHJvbGxlci9BZG1pbi9BcHBBZG1pbkNvbnRyb2xsZXIucGhw')) .
                    md5_file(APP . base64_decode('Q29udHJvbGxlci9BZG1pbi9BY3RpdmF0aW9uQ29udHJvbGxlci5waHA=')) .
                    md5_file(APP . base64_decode('TW9kZWwvVGFibGUvQWN0aXZhdGlvblRhYmxlLnBocA==')));
            }
            if ($md5 != '68afc8d02eb54277ecd493a7e37f74de') {
                exit();
            }
        }
    }
});
